<?php

namespace Kirby\Entities;

use Obj;

class Roots extends Obj {

  public $index;

  public function __construct($root) {

    $this->index = $root;

    $this->templates = $this->index . DS . 'templates';
    $this->layouts   = $this->index . DS . 'layouts';
    $this->actions   = $this->index . DS . 'actions';

  }

  public function __debuginfo() {
    return parent::__debuginfo();
  }

}
