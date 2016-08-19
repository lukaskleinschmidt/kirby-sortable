<?php

namespace Kirby\Field\Modules;

class Module extends \Kirby\Modules\Module {
  public $page;
  public $preview = true;
  public $delete = true;
  public $edit = true;
  public $max = 0;

  public function __construct($page, $test) {
    $this->page = $page;

    // Call parent constructor
    parent::__construct($page);
  }

  public function test() {
    return 'test: ' . $this->name;
  }
}