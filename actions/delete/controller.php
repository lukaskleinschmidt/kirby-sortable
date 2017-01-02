<?php

class DeleteActionController extends SubpagesFieldController {

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

}
