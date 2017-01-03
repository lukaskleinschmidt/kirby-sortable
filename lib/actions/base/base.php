<?php

class BaseAction {

  public $num;
  public $numVisible;
  public $page;
  public $field;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __call($name, $args) {
    return isset($this->{$name}) ? $this->{$name} : null;
  }

  public function url($action, $params = []) {
    return $this->field()->url($action, $params);
  }

  public function template() {
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function __toString() {
    try {
      return (string)$this->template();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
