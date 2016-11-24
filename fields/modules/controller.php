<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {

  /**
   * Add a module
   */
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

        $self->update($self->field()->modules()->pluck('uid'));
        $self->notify(':)');
        $this->redirect($self->model());
        // $this->redirect($page, 'edit');

      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

    });

    return $this->modal('add', compact('form'));

  }

  /**
   * Delete a module
   * @param string $uid
   */
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
        $self->update($self->field()->modules()->not($page)->pluck('uid'));
        $self->notify(':)');
        $self->redirect($self->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('delete', compact('form'));

  }

  /**
   * Duplicate a module
   * @param string $uid
   * @param int $to
   */
  public function duplicate($uid, $to) {

    $modules = $this->field()->modules();
    $parent  = $this->field()->origin();
    $page    = $modules->find($uid);
    $uid     = $this->uid($page);

    if($parent->ui()->create() === false) {
      throw new PermissionsException();
    }

    dir::copy($page->root(), $parent->root() . DS . $uid);

    $this->sort($uid, $to);
    $this->notify(':)');
    $this->redirect($this->model());

  }

  /**
   * Update field value and sort number
   * @param string $uid
   * @param int $to
   */
  public function sort($uid, $to) {

    $modules = $this->field()->modules();
    $value = $modules->not($uid)->pluck('uid');

    // Order modules value
    array_splice($value, $to - 1, 0, $uid);

    // Update field value
    $this->update($value);

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
   * Show page
   * @param string $uid
   * @param int $to
   */
  public function show($uid, $to) {

    // Load translation
    $this->field()->translation();

    $modules = $this->field()->modules();
    $page    = $modules->find($uid);

    if($page->ui()->visibility() === false) {
      throw new PermissionsException();
    }

    try {

      // Check module specific limit
      $count = $modules->filterBy('template', $page->intendedTemplate())->visible()->count();
      $limit = $this->field()->options($page)->limit();

      if($limit && $count >= $limit) {
        throw new Exception(l('fields.modules.module.limit'));
      }

      // Check limit
      $count = $modules->visible()->count();
      $limit = $this->field()->limit();

      if($limit && $count >= $limit) {
        throw new Exception(l('fields.modules.limit'));
      }

      $page->sort($to);
      $this->notify(':)');

    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($this->model());

  }

  /**
   * Hide page
   * @param string $uid
   */
  public function hide($uid) {

    $page = $this->field()->modules()->find($uid);

    if($page->ui()->visibility() === false) {
      throw new PermissionsException();
    }

    try {
      $page->hide();
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($this->model());

  }

  /**
   * Copy to clipboard
   */
  public function copy() {

    $origin  = $this->field()->origin()->uri();
    $modules = get('modules', array());

    cookie::set('kirby_field_modules', compact('origin', 'modules'), 60);

    $this->notify(':)');

  }

  /**
   * Add from clipboard
   */
  public function paste() {

    // Load translation
    $this->field()->translation();

    $self = $this;
    $page = $this->field()->origin();


    if(cookie::exists('kirby_field_modules')) {

      $cookie = cookie::get('kirby_field_modules', array());
      $cookie = new Obj(json_decode($cookie));

      $modules = page($cookie->origin())->children()->find($cookie->modules());
      // return $this->modal('paste', array('form' => 'test'));

      if(is_a($modules, 'Page')) {
        $module = $modules;
        $modules = new Children(page($cookie->origin()));
        $modules->data[$module->id()] = $module;
      }
    } else {
      $modules = new Children('test');
    }

    if($page->ui()->create() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('paste', array($page, $modules, $this->model()), function($form) use($page, $self) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      try {
        // $template = get('module');
        // $modules = $field->modules();
        // $uid = $self->uid($template);

        // $modules->create($uid, $template);
        // $self->_sort($uid, $modules->count());
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

      $self->redirect($self->model());

    });

    return $this->modal('paste', compact('form'));

    // $this->redirect($this->model());

  }

  /**
   * Update the field value
   * @param array $value
   */
  public function update($value) {

    try {
      $this->model()->update(array(
        $this->field()->name() => implode(', ', $value)
      ));
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

  /**
   * Create uid
   * @param  string $template
   * @return string
   */
  public function uid($template) {

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

}
