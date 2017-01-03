<?php

class BaseEntity extends Obj {

  public $field;
  public $page;
  public $num;
  public $numVisible;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __call($name, $args) {
    return isset($this->{$name}) ? $this->{$name} : null;
  }

  public function counter() {

  }

  public function action($name) {
    //   $action = static::$entities->action($name);
    //
    //   foreach($options as $key => $value) {
    //     $action->$key = $value;
    //   }
    //
    //   return $action;
    return $this->field()->action($name, ['entity' => $this]);
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
