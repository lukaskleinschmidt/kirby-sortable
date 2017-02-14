<?php

use Kirby\Panel\Models\Page\Blueprint;

class PasteActionController extends Kirby\Sortable\Controllers\Action {

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
      throw new PermissionsException();
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

        foreach(pages(str::split($data['uri'], ',')) as $entry) {

          if(!v::in($entry->intendedTemplate(), $templates)) continue;

          $template  = $entry->intendedTempalte();
          $blueprint = new Blueprint($template);
          $data      = array();
          $uid       = $self->uid($entry);

          foreach($blueprint->fields(null) as $key => $field) {
            $data[$key] = $field->default();
          }

          $data  = array_merge($data, $entry->content()->toArray());
          $event = $parent->event('create:action', [
            'parent'    => $parent,
            'template'  => $template,
            'blueprint' => $blueprint,
            'uid'       => $uid,
            'data'      => $data
          ]);

          $event->check();

          dir::copy($entry->root(), $parent->root() . DS . $uid);

          $page = $parent->children()->find($uid);

          if(!$page) {
            throw new Exception(l('pages.add.error.create'));
          }

          kirby()::$triggered = array();

          kirby()->trigger($event, $page);

          $entries->add($uid);
          $self->sort($uid, ++$to);

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
