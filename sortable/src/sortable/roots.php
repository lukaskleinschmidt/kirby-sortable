<?php

namespace LukasKleinschmidt\Sortable;

use Obj;

class Roots extends Obj {

  public $index;

  public function __construct($root) {

    $this->index = $root;

    $this->translations = $this->index . DS . 'translations';
    $this->variants     = $this->index . DS . 'variants';
    $this->layouts      = $this->index . DS . 'layouts';
    $this->actions      = $this->index . DS . 'actions';

  }

  public function __debuginfo() {
    return parent::__debuginfo();
  }

}
