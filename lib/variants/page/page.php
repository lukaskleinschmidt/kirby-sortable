<?php

class PageVariant extends Obj {

  public $field;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __construct($field, $data = array()) {
    $this->field = $field;
    parent::__construct($data);
  }

  public function field() {
    return $this->field;
  }

  public function counter() {
    return '( 1 / 2 )';
  }

  public function action($type, $data = array()) {
    $data = a::update($data, ['entity' => $this]);
    return Kirby\Entities\Entities::action($type, $data);
  }

  public function template() {
    return tpl::load($this->root() . DS . 'template.php', ['entity' => $this], true);
  }

  public function __toString() {
    try {
      return (string)$this->template();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
