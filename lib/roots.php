<?php

namespace Kirby\Entities;

use Obj;

class Roots extends Obj {

  public $index;

  public function __construct($root) {

    $this->index = $root;
    $this->lib   = $root . DS . 'lib';

    $this->templates = $this->lib . DS . 'templates';
    $this->variants  = $this->lib . DS . 'variants';
    $this->actions   = $this->lib . DS . 'actions';

  }

  public function __debuginfo() {
    return parent::__debuginfo();
  }

}
