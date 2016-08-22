<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {
  public function add() {

    // $this->options = $page

    // $templates = str::split(get('templates'), ',');
    $page = $this->origin();

    dump($this->origin()->blueprint()->field());
    dump($page->blueprint()->pages()->template);
    dump($page->children()->count());

    $form = $this->form('add', array($page, $this->model()));

    // return $this->modal('add', compact('form', 'templates'));
    return $this->modal('add', compact('form'));
  }

  public function delete() {
    $page = $this->origin()->find(get('uid'));

    $form = $this->form('delete', array($page, $this->model()));
    $form->style('delete');

    return $this->modal('delete', compact('form'));
  }

  public function origin() {
    // Determine where the modules live
    if(!$origin = $this->model()->find(Kirby\Modules\Modules::parentUid())) {
      $origin = $this->model();
    }

    return $origin;
  }

  public function options($template) {
    // Get module specific options
    $options = a::get($this->modules, $template, array());

    return a::update($this->options, $options);
  }
}