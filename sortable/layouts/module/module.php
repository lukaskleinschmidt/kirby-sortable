<?php

class ModuleLayout extends BaseLayout {

  public $edit      = true;
  public $limit     = false;
  public $toggle    = true;
  public $delete    = true;
  public $preview   = true;
  public $duplicate = true;

  public function preview() {

    $page = $this->page();

    if(!$preview = $this->preview) {
      return;
    }

    $entry = Kirby\Modules\Modules::instance()->get($page);
    $template = $entry->path() . DS . $entry->name() . '.preview.php';

    if(!is_file($template)) {
      return;
    }

    $position = $preview === true ? 'top' : $preview;

    $preview = new Brick('div');
    $preview->addClass('modules-layout__preview modules-layout__preview--' . $position);
    $preview->data('module', $entry->name());
    $preview->data('handle', true);
    $preview->html(tpl::load($template, array('page' => $this->origin(), 'module' => $page, 'moduleName' => $entry->name())));

    return $preview;

  }

  public function action($type, $data = array()) {

    $data = a::update($data, array(
      'disabled' => $this->$type() === false
    ));

    return parent::action($type, $data);

  }

}
