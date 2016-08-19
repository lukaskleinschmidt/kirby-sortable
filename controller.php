<?php

use Kirby\Modules;

class ModulesFieldController extends Kirby\Panel\Controllers\Field {
  public function add() {
    $page = $this->root();

    $form = $this->form('add', array($page, $this->model()));

    return $this->modal('add', compact('form'));
  }

  public function delete() {
    $page = $this->root()->find(get('uid'));

    $form = $this->form('delete', array($page, $this->model()));
    $form->style('delete');

    return $this->modal('delete', compact('form'));
  }

  public function root() {
    // Determine where the modules live
    if(!$root = $this->model()->find(Modules\Modules::parentUid())) {
      $root = $this->model();
    }

    return $root;
  }
}