<?php

namespace Kirby\Field\Modules;

class Module extends Obj {

  public function __construct($page, $field) {

    $this->page   = $page;
    $this->field  = $field;
    $this->module = new Kirby\Modules\Modules::module($page);

  }

  public function preview() {

    $template = $module->path() . DS . $module->name() . '.preview.php';

    if(!is_file($template)) {
      return null;
    }

    return tpl::load($template, array('module' => $this->page()));

  }

}
