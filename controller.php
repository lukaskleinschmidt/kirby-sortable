<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  public function add() {

    $model = $this->model();
    $field = $this->field();
    $self  = $this;

    $form = $this->form('add', array($model, $field), function($form) use($model, $self) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $modules = $self->field()->modules();
      $uid = 'module' . time();

      try {
        $modules->create($uid, get('module'));
        $self->update($uid, get('to', $modules->count()));
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

      $self->redirect($model);
    });

    return $this->modal('add', compact('form'));

  }

  public function delete() {

    $model = $this->model();
    $self  = $this;
    $uid = get('uid');

    $form = $this->form('delete', array($model), function($form) use($model, $self, $uid) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $modules = $self->field()->modules();

      try {
        $modules->find($uid)->delete(true);
        $self->_update($modules->not($uid)->pluck('uid'));
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

      $self->redirect($model);
    });

    return $this->modal('delete', compact('form'));

  }

  public function duplicate() {

    $uid = get('uid');
    $to  = get('to');

    $page = $this->field()->modules()->find($uid);
    $uid  = 'duplicate-' . time();

    dir::copy($page->root(), $this->field()->origin()->root() . DS . $uid);

    $this->notify(':)');
    $this->update($uid, $to);

  }

  public function show() {

    $to   = get('to');
    $uid  = get('uid');
    $page = $this->field()->modules()->find($uid);

    if(!$this->field()->status($page)) {
      return $this->alert('Limit reached');
    }

    try {
      $page->sort($to);
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

  public function hide() {

    try {
      $this->field()->modules()->find(get('uid'))->hide();
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

  public function sort() {
    $this->update(get('uid'), get('to'));
  }

  public function options() {

    $uid    = get('uid');
    $field  = $this->field();
    $module = $field->modules()->find($uid);

    return $this->view('options', compact('field', 'module'));

  }

  /**
   * Update field value and sort number
   * @param [string] $uid
   * @param [int] $to
   */
  public function update($uid, $to) {

    $modules = $this->field()->modules();
    $value = $modules->not($uid)->pluck('uid');

    // Order modules value
    array_splice($value, $to - 1, 0, $uid);

    // Update field value
    $this->_update($value);

    // Get current page
    $page = $modules->find($uid);

    // Figure out the correct sort num
    if($page && $page->isVisible()) {
      $collection = new Children($page->parent());

      foreach(array_slice($value, 0, $to - 1) as $id) {
        if($module = $modules->find($id)) {
          $collection->data[$module->id()] = $module;
        }
      }

      try {
        // Sort the page
        $page->sort($collection->visible()->count() + 1);
      } catch(Exception $e) {
        $this->alert($e->getMessage());
      }
    }

  }

  /**
   * Update the field value
   * @param [array] $value
   */
  public function _update($value) {

    try {
      $this->model()->update(array(
        $this->field()->name() => implode(', ', $value)
      ));
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

}
