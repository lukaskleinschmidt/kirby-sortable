<?php

class DeleteActionController extends LukasKleinschmidt\Sortable\Controllers\Action {

  /**
   * Delete a entry
   *
   * @param string $uid
   */
  public function delete($uid) {

    $self = $this;
    $page = $this->field()->entries()->find($uid);

    if($page->ui()->delete() === false) {
      throw new Kirby\Panel\Exceptions\PermissionsException();
    }

    $form = $this->form('delete', array($page, $this->model(), $this->field()), function($form) use($page, $self) {

      try {

        $page->delete();
        $self->update($self->field()->entries()->not($page)->pluck('uid'));
        $self->notify(':)');
        $self->redirect($self->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('delete', compact('form'));

  }

}
