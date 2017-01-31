<?php

class PasteActionController extends Kirby\Sortable\Controllers\Action {

  /**
   * Add from clipboard
   */
  public function paste() {

    $self    = $this;
    $page    = $this->field()->origin();
    $entries = site()->user()->clipboard();

    if(empty($entries)) {
      $entries = array();
    }

    $entries = pages($entries);

    if($page->ui()->create() === false) {
      throw new PermissionsException();
    }

    $form = $this->form('paste', array($page, $entries, $this->model(), $this->field()), function($form) use($page, $self) {

      try {

      $form->validate();

        if(!$form->isValid()) {
          throw new Exception($self->field()->l('field.sortable.paste.error.uri'));
        }

        $data = $form->serialize();

        $templates = $page->blueprint()->pages()->template()->pluck('name');
        $entries   = $self->field()->entries();
        $to        = $entries->count();

        foreach(pages(str::split($data['uri'], ',')) as $entry) {

          $uid = $self->uid($entry);

          if(v::in($entry->intendedTemplate(), $templates)) {
            dir::copy($entry->root(), $page->root() . DS . $uid);
            $entries->add($uid);
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
