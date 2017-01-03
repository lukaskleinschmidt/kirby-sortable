<?php

namespace Kirby\Entities;

use Obj;

class Roots extends Obj {

  public $index;

  public function __construct($root) {

    $this->index = $root;
    $this->lib   = $root . DS . 'lib';

    $this->actions = $this->lib . DS . 'actions';
    $this->entities  = $this->lib . DS . 'entities';

  }

  public function __debuginfo() {
    return parent::__debuginfo();
  }

}
