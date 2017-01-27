<?php

class ModulesField extends SortableField {

  public $variant = 'modules';
  public $actions = array(
    'edit',
    'duplicate',
    'delete',
    'toggle',
  );
  public $layout = 'module';
  public $paste = true;
  public $copy = true;
  public $add = true;

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
