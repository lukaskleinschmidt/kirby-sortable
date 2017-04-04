<?php

namespace LukasKleinschmidt\Sortable\Controllers;

use Kirby\Panel\View;
use Kirby\Panel\Snippet;

class Action extends Field {

  public function __construct($model, $field, $action) {

    $this->model  = $model;
    $this->field  = $field;
    $this->action = $action;

  }

  public function form($id, $data = array(), $submit = null) {
    $file = $this->action->root() . DS . 'forms' . DS . $id . '.php';
    return panel()->form($file, $data, $submit);
  }

  public function view($file, $data = array()) {

    $view = new View($file, $data);
    $root = $this->action->root() . DS . 'views';

    if(file_exists($root . DS . $file . '.php')) {
      $view->_root = $root;
    }

    return $view;

  }

  public function snippet($file, $data = array()) {

    $snippet = new Snippet($file, $data);
    $root    = $this->action->root() . DS . 'snippets';

    if(file_exists($root . DS . $file . '.php')) {
      $snippet->_root = $root;
    }

    return $snippet;

  }

}
