<?php

class BaseAction {

  public $name;
  public $icon;
  public $type;
  public $title;
  public $disabled;
  public $page;
  public $model;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __call($name, $args) {
    return isset($this->{$name}) ? $this->{$name} : null;
  }

  public function icon() {

    if(empty($this->icon)) {
      return null;
    }

    $icon = new Brick('i');
    $icon->addClass('icon fa fa-' . $this->icon);

    return $icon;

  }

  public function element() {

    $element = new Brick('a');
    $element->addClass('module__action');

    if($this->title)
      $element->attr('title', $this->title);
    }

    if($this->type)
      $element->attr($this->type, true);
    }

    if($this->disabled)
      $element->addClass('is-disabled');
    }

    return $element;

  }

  public function template() {

    return $this->element()
      ->append($this->icon());

  }

  public function __toString() {
    try {
      return (string)$this->template();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
