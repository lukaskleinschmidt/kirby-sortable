<?php

class BaseAction {

  public $icon;
  public $label;
  public $title;
  public $type;
  public $disabled = false;

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

  public function url($params = []) {
    return $this->field()->url($this->type, $params);
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
    if(empty($this->layout)) return $this->field()->page();
    return $this->layout()->page();
  }

  public function __toString() {
    try {
      return (string)$this->content();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
