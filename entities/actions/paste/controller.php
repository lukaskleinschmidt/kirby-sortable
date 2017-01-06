<?php

class PasteActionController extends Kirby\Entities\Controllers\Action {
  
  /**
   * Add from clipboard
   */
  public function paste() {

    // Load translation
    $this->field()->translation();

    $self    = $this;
    $page    = $this->field()->origin();
    $modules = site()->user()->clipboard();

    if(empty($modules)) {
      $modules = array();
    }

    $modules = pages($modules);

    if($page->ui()->create() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('paste', array($page, $modules, $this->model()), function($form) use($page, $self) {

      try {

      $form->validate();

        if(!$form->isValid()) {
          throw new Exception(l('fields.modules.paste.error.uri'));
        }

        $data = $form->serialize();

        $templates = $page->blueprint()->pages()->template()->pluck('name');
        $modules   = $self->field()->children();
        $to        = $modules->count();

        foreach(pages(str::split($data['uri'], ',')) as $module) {

          $uid = $self->uid($module);

          if(v::in($module->intendedTemplate(), $templates)) {
            dir::copy($module->root(), $page->root() . DS . $uid);
            $modules->add($uid);
            $self->sort($uid, ++$to);
          }
        }

        $self->notify(':)');
        $self->redirect($self->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('paste', compact('form'));

  }

}
