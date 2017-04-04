<?php

class PasteActionController extends LukasKleinschmidt\Sortable\Controllers\Action {

  /**
   * Add from clipboard
   */
  public function paste() {

    $self    = $this;
    $parent  = $this->field()->origin();
    $entries = site()->user()->clipboard();

    if(empty($entries)) {
      $entries = array();
    }

    $entries = pages($entries);

    if($parent->ui()->create() === false) {
      throw new Kirby\Panel\Exceptions\PermissionsException();
    }

    $form = $this->form('paste', array($parent, $entries, $this->model(), $this->field()), function($form) use($parent, $self) {

      try {

        $form->validate();

        if(!$form->isValid()) {
          throw new Exception($self->field()->l('field.sortable.paste.error.uri'));
        }

        $data = $form->serialize();

        $templates = $parent->blueprint()->pages()->template()->pluck('name');
        $entries   = $self->field()->entries();
        $to        = $entries->count();

        foreach(pages(str::split($data['uri'], ',')) as $page) {

          if(!in_array($page->intendedTemplate(), $templates)) continue;

          // Reset previously triggered hooks
          kirby()::$triggered = array();

          $page = $self->copy($page, $parent);

          $entries->add($page->uid());
          $self->sort($page->uid(), ++$to);

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
