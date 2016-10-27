<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  protected $origin;

  public function add() {
  }

  public function delete() {
  }

  public function duplicate() {
  }

  public function show() {

    $model = $this->model;
    $self  = $this;
    $uid   = get('uid');
    $to    = get('to');

    $form = $this->form('show', array($model), function($form) use($model, $self, $uid, $to) {
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $self->field()->modules()->find($uid)->sort($to);
      $self->redirect($model);
    });

    return $this->modal('show', compact('form'));

  }

  public function hide() {

    $model = $this->model;
    $self  = $this;
    $uid   = get('uid');

    $form = $this->form('hide', array($model), function($form) use($model, $self, $uid) {
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $self->field()->modules()->find($uid)->hide();
      $self->redirect($model);
    });

    return $this->modal('hide', compact('form'));

  }

  public function sort() {

    $uid = get('uid');
    $to  = get('to');
    $modules = $this->field->modules();
    $value = $modules->not($uid)->pluck('uid');

    // Order modules value
    array_splice($value, $to - 1, 0, $uid);

    // Update field
    $this->model->update(array(
      $this->field->name() => implode(', ', $value)
    ));

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
      $page->sort($collection->visible()->count() + 1);
    }

    return $this->modal('sort');

  }

}
