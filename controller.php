<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  protected $origin;

  public function add() {
    return $this->view('add');
  }

  public function delete() {

    $model = $this->model;
    $self  = $this;
    $uid = get('uid');

    $form = $this->form('delete', array($model), function($form) use($model, $self, $uid) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      try {
        $self->field()->modules()->find($uid)->delete(true);
      } catch(Exception $e) {
        echo $e->getMessage();
      }

      $self->redirect($model);
    });

    return $this->modal('delete', compact('form'));

  }

  public function duplicate() {

    $uid   = get('uid');
    $to    = get('to');

    $page = $this->field()->modules()->find($uid);
    $uid  = 'test-' . time();

    dir::copy($page->root(), $this->field()->origin()->root() . DS . $uid);

    $this->update($uid, $to);

  }

  public function show() {

    $uid = get('uid');
    $to  = get('to');

    try {
      $this->field()->modules()->find($uid)->sort($to);
    } catch(Exception $e) {
      echo $e->getMessage();
    }

  }

  public function hide() {

    $uid = get('uid');

    try {
      $this->field()->modules()->find($uid)->hide();
    } catch(Exception $e) {
      echo $e->getMessage();
    }

  }

  public function sort() {

    $uid = get('uid');
    $to  = get('to');

    $this->update($uid, $to);

  }

  public function update($uid, $to) {

    $modules = $this->field->modules();
    $value = $modules->not($uid)->pluck('uid');

    // Order modules value
    array_splice($value, $to - 1, 0, $uid);

    // Update field
    try {
      $this->model->update(array(
        $this->field->name() => implode(', ', $value)
      ));
    } catch(Exception $e) {
      echo $e->getMessage();
    }

    // Get current page
    $page = $modules->find($uid);

    // Figure out the correct sort num
    if($page->isVisible()) {
      $collection = new Children($page->parent());

      foreach(array_slice($value, 0, $to - 1) as $id) {
        if($module = $modules->find($id)) {
          $collection->data[$module->id()] = $module;
        }
      }

      // Sort the page
      try {
        $page->sort($collection->visible()->count() + 1);
      } catch(Exception $e) {
        echo $e->getMessage();
      }
    }

  }

}
