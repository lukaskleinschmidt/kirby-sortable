<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  public function add() {

    // Load translation
    $this->field()->translation();

    $self   = $this;
    $parent = $this->field()->origin();

    if($parent->ui()->create() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('add', array($parent, $this->model()), function($form) use($parent, $self) {

      try {

        $form->validate();

        if(!$form->isValid()) {
          throw new Exception(l('pages.add.error.template'));
        }

        $data = $form->serialize();
        $template = $data['template'];

        $page = $parent->children()->create($self->uid($template), $template, array(
          'title' => $parent->blueprint()->pages()->template()->findBy('name', $template)->title()
        ));

        $self->update();
        $self->notify(':)');
        $this->redirect($self->model());
        // $this->redirect($page, 'edit');

      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

    });

    return $this->modal('add', compact('form'));

  }

  public function delete($uid) {

    // Load translation
    $this->field()->translation();

    $self = $this;
    $page = $this->field()->modules()->find($uid);

    if($page->ui()->delete() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('delete', array($page, $this->model()), function($form) use($page, $self) {

      try {

        $page->delete();
        $self->update();
        $self->notify(':)');
        $self->redirect($self->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('delete', compact('form'));

  }



  public function duplicate($uid, $to) {

    $page = $this->field()->modules()->find($uid);
    $uid  = $this->_uid($page);

    dir::copy($page->root(), $this->field()->origin()->root() . DS . $uid);

    $this->notify(':)');
    $this->_sort($uid, $to);
    $this->redirect($this->model());

  }

  public function show() {

    $to   = get('to');
    $uid  = get('uid');
    $page = $this->field()->modules()->find($uid);

    try {
      $this->_show($page, $to);
      $this->notify(':)');
    } catch (Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($this->model());

  }

  public function hide() {

    $this->_hide($this->field()->modules()->find(get('uid')));
    $this->redirect($this->model());

  }

  public function sort() {
    $this->_sort(get('uid'), get('to'));
  }

  public function copy() {

    $origin = $this->field()->origin()->uri();
    $modules = get('modules', array());

    cookie::set('kirby_field_modules_clipboard', compact('origin', 'modules'), 60);

  }

  public function paste() {

    $model = $this->model();
    $field = $this->field();
    $self  = $this;

    // Load translation
    $field->translation();

    $form = $this->form('paste', array($model, $field), function($form) use($model, $self, $field) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      try {
        // $template = get('module');
        // $modules = $field->modules();
        // $uid = $self->_uid($template);

        // $modules->create($uid, $template);
        // $self->_sort($uid, $modules->count());
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

      $self->redirect($model);
    });

    return $this->modal('paste', compact('form'));

  }

  // public function options() {
  //
  //   $uid    = get('uid');
  //   $field  = $this->field();
  //   $module = $field->modules()->find($uid);
  //
  //   return $this->view('options', compact('field', 'module'));
  //
  // }


  public function update() {
    $value = $this->field()->origin()->children()->pluck('uid');
    $this->_update($value);
  }

  public function uid($template) {
    return $this->_uid($template);
  }

  /**
   * Create uid
   * @param  string $template
   * @return string
   */
  public function _uid($template) {

    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    $templatePrefix = Kirby\Modules\Modules::templatePrefix();
    $length = str::length($templatePrefix);
    $name = str::substr($template, $length);

    // add a unique hash
    $checksum = sprintf('%u', crc32($name . microtime()));
    return $name . '-' . base_convert($checksum, 10, 36);

  }

  /**
   * Update field value and sort number
   * @param string $uid
   * @param int $to
   */
  public function _sort($uid, $to) {

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
   * @param array $value
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

  /**
   * Show page
   * @param Page $page Page object
   */
  public function _show($page, $to) {

    $field = $this->field();

    // Load translation
    $field->translation();

    // Check module specific limit
    $count = $field->modules()->filterBy('template', $page->intendedTemplate())->visible()->count();
    $limit = $field->options($page)->limit();

    if($limit && $count >= $limit) {
      throw new Exception(l('fields.modules.module.limit'));
      return;
    }

    // Check limit
    $count = $field->modules()->visible()->count();
    $limit = $field->limit();

    if($limit && $count >= $limit) {
      throw new Exception(l('fields.modules.limit'));
      return;
    }

    // Update page
    $page->sort($to);

  }

  /**
   * Hide page
   * @param Page $page Page object
   */
  public function _hide($page) {

    try {
      $page->hide();
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

}
