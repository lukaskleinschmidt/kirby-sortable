<?php

class ModulesFieldController extends Kirby\Panel\Controllers\Field {
  public $options = array();
  public $modules = array();

  public function add() {
    $page = $this->model();
    $origin = $this->origin();

    $field = $this->field($this->fieldname());

    $this->options = $field->options;
    $this->modules = $field->modules;

    $modules = $this->modules($origin);

    $form = $this->form('add', array($origin, $page, $modules));

    $options = array(
      'redirect' => $page->uri('edit'),
      'modules' => $modules,
    );

    return $this->modal('add', compact('form', 'options'));
  }

  public function delete() {
    $page = $this->origin()->find(get('uid'));

    $form = $this->form('delete', array($page, $this->model()));
    $form->style('delete');

    return $this->modal('delete', compact('form'));
  }

  public function modules($page) {
    $templates = $page->blueprint()->pages()->template();
    $modules = array();

    foreach($templates as $template) {
      $modules[] = array(
        'title' => $template->title(),
        'options' => $this->options($template->name()),
        'template' => $template->name(),
      );
    }

    return $modules;
  }

  public function field($name) {
    $fields = $this->model()->blueprint()->fields(null);
    return $fields->get($name);
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