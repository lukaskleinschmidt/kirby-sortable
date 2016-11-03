<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  public function add() {

    $templates = array();

    foreach($this->field()->origin()->blueprint()->pages()->template() as $template) {
      $templates[] = array(
        'options' => $this->options($template->name()),
        'title' => $template->title(),
        'name' => $template->name(),
      );
    }

    $page = $this->model();

    $form = $this->form('add', array($this->field()->origin(), $page, $templates));

    $options = array(
      'templates' => $templates,
      'redirect' => $page->uri('edit'),
    );

    return $this->modal('add', compact('form', 'options'));
    // return $this->view('add');
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
    panel()->notify(':)');

    $this->update($uid, $to);

  }

  public function show() {

    $to   = get('to');
    $uid  = get('uid');
    $page = $this->field()->modules()->find($uid);

    if(!$this->field()->status($page)) {
      return panel()->alert('Limit reached');
    }

    try {
      $page->sort($to);
      panel()->notify(':)');
    } catch(Exception $e) {
      echo $e->getMessage();
    }

  }

  public function hide() {

    try {
      $this->field()->modules()->find(get('uid'))->hide();
      panel()->notify(':)');
    } catch(Exception $e) {
      echo $e->getMessage();
    }

  }

  public function sort() {
    $this->update(get('uid'), get('to'));
  }

  public function update($uid, $to) {

    $modules = $this->field->modules();
    $value = $modules->not($uid)->pluck('uid');

    // Order modules value
    array_splice($value, $to - 1, 0, $uid);

    try {
      // Update field
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

      try {
        // Sort the page
        $page->sort($collection->visible()->count() + 1);
      } catch(Exception $e) {
        echo $e->getMessage();
      }
    }

  }

}
