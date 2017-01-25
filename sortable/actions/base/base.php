<?php

class BaseAction {

  public $icon;
  public $type;
  public $label;
  public $title;
  public $field;
  public $layout;
  public $page;
  public $disabled = false;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __construct($type, $field = null, $page = null, $layout = null) {
    $this->type = $type;
    $this->page = $page;
    $this->field = $field;
    $this->layout = $layout;
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
