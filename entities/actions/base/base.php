<?php

class BaseAction {

  public $icon;
  public $label;
  public $title;
  public $type;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __construct($type) {
    $this->type = $type;
  }

  public function __call($method, $arguments) {
    return isset($this->$method) ? $this->$method : null;
  }

  public function type() {
    return $this->type;
  }

  public function url($action, $params = []) {
    return $this->field()->url($action, $params);
  }

  public function i18n($value) {
    return i18n($value);
  }

  public function icon($position = null) {
    if(empty($this->icon)) return null;
    return icon($this->icon, $position);
  }

  public function label() {
    if(empty($this->label)) return null;
    return $this->i18n($this->label);
  }

  public function title() {
    if(empty($this->title)) return null;
    return $this->i18n($this->title);
  }

  public function page() {
    if(empty($this->entity)) return $this->field()->page();
    return $this->entity()->page();
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
