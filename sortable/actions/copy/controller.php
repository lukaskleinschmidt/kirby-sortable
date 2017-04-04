<?php

class CopyActionController extends LukasKleinschmidt\Sortable\Controllers\Action {

  /**
   * Save to clipboard
   */
  public function save() {

    $self    = $this;
    $page    = $this->field()->origin();
    $entries = $this->field()->entries();

    $form = $this->form('copy', array($page, $entries, $this->model(), $this->field()), function($form) use($page, $self) {

      try {

        $form->validate();

        if(!$form->isValid()) {
          throw new Exception($self->field()->l('field.sortable.copy.error.uri'));
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
