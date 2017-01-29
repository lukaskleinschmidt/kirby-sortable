<?php

class ModulesField extends SortableField {

  public $add     = true;
  public $copy    = true;
  public $paste   = true;
  public $layout  = 'module';
  public $variant = 'modules';
  public $actions = array(
    'edit',
    'duplicate',
    'delete',
    'toggle',
  );

  static public $assets = array(
    'css' => array(
      'modules.css',
    ),
  );

  public function parent() {
    return Kirby\Modules\Settings::parentUid();
  }

  public function prefix() {
    return Kirby\Modules\Settings::templatePrefix();
  }

}
