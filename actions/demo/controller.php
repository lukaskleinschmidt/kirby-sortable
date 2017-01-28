<?php

class DemoActionController extends Kirby\Sortable\Controllers\Action {

  public function demo($uid) {

    $self = $this;
    $page = $this->field()->entries()->find($uid);

    if($page->ui()->update() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('demo', array($this->model(), $this->field()), function($form) use($page, $self) {

      try {

        $page->update(array(
          'title' => $page->title() . ' 🟊',
        ));

        $self->notify('🟊');
        $self->redirect($self->model());

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('demo', compact('form'));

  }

}
