<?php

class BaseAction {

  public $type;
  public $icon;
  public $label;
  public $title;
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

    if(is_array($value)) {
      return i18n($value);
    }

    return $this->field()->l($value);

  }

  public function l($key, $variant = null) {
    return $this->field()->l($key, $variant);
  }

  public function icon($position = null) {
    if(!$this->icon) return null;
    return icon($this->icon, $position);
  }

  public function label() {
    if(!$this->label) return null;
    return $this->i18n($this->label);
  }

  public function title() {
    if(!$this->title) return null;
    return $this->i18n($this->title);
  }

  public function __toString() {
    try {
      return (string)$this->content();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
