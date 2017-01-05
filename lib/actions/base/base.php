<?php

class BaseAction {

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __call($method, $arguments) {
    return isset($this->$method) ? $this->$method : null;
  }

  public function url($action, $params = []) {
    return $this->entity()->field()->url($action, $params);
  }

  public function label() {

  }

  public function title() {

  }

  public function icon() {

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
