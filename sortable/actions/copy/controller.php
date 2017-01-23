<?php

class CopyActionController extends Kirby\Sortable\Controllers\Action {
  
  /**
   * Copy to clipboard
   */
  public function copy() {

    // Load translation
    $this->field()->translation();

    $self    = $this;
    $page    = $this->field()->origin();
    $modules = $this->field()->entries();

    $form = $this->form('copy', array($page, $modules, $this->model()), function($form) use($page, $self) {

      try {

        $form->validate();

        if(!$form->isValid()) {
          throw new Exception(l('fields.modules.copy.error.uri'));
        }

        $data = $form->serialize();

        site()->user()->update(array(
          'clipboard' => str::split($data['uri']),
        ));

        $self->notify(':)');
        $self->redirect($this->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('copy', compact('form'));

  }

}
