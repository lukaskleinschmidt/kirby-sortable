<?php

namespace Kirby\Sortable;

use F;
use Dir;
use Str;
use Exception;

class Sortable {

  static public $instance;

  public $kirby;
  public $roots;
  public $registry;

  protected $loaded = false;

  public function __construct() {

    $this->kirby = kirby();

    $this->roots    = new Roots(dirname(__DIR__));
    $this->registry = new Registry($this->kirby());

  }

  public static function instance() {
    if(!is_null(static::$instance)) return static::$instance;
    return static::$instance = new static();
  }

  public static function translation() {
    return;
  }

  public static function layout($type, $field, $page, $data = array()) {

    $class = $type . 'layout';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' layout is missing.');
    }

    $layout = new $class($type, $field, $page);

    foreach($data as $key => $val) {
      if(!is_string($key) || str::length($key) === 0) continue;
      $layout->{$key} = $val;
    }

    return $layout;

  }

  public static function action($type, $field = null, $page = null, $layout = null, $data = array()) {

    $class = $type . 'action';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' action is missing.');
    }

    $action = new $class($type, $field, $page, $layout);

    foreach($data as $key => $val) {
      if(!is_string($key) || str::length($key) === 0) continue;
      $action->{$key} = $val;
    }

    return $action;

  }

  public function register() {

    $kirby = $this->kirby();

    // set default templates
    foreach(dir::read($this->roots()->templates()) as $name) {
      $this->set('template', f::name($name), $this->roots()->templates() . DS . $name);
    }

    // set default layouts
    foreach(dir::read($this->roots()->layouts()) as $name) {
      $this->set('layout', f::name($name), $this->roots()->layouts() . DS . $name);
    }

    // set default actions
    foreach(dir::read($this->roots()->actions()) as $name) {
      $this->set('action', $name, $this->roots()->actions() . DS . $name);
    }

  }

  public function load() {

    $classes = [];

    foreach($this->get('layout') as $name => $layout) {
      $classes[$layout->class()] = $layout->file();
    }

    foreach($this->get('action') as $name => $action) {
      $classes[$action->class()] = $action->file();
    }

    load($classes);

    $this->loaded = true;

  }

  public function kirby() {
    return $this->kirby;
  }

  public function roots() {
    return $this->roots;
  }

  public function set() {
    return call_user_func_array([$this->registry, 'set'], func_get_args());
  }

  public function get() {
    return call_user_func_array([$this->registry, 'get'], func_get_args());
  }

}
