<?php

namespace Kirby\Elements;

use F;
use Dir;
use Str;
use Exception;

class Elements {

  static public $instance;

  public $kirby;
  public $roots;
  public $registry;

  public static function instance() {
    if(!is_null(static::$instance)) return static::$instance;
    return static::$instance = new static();
  }

  public function __construct() {

    $this->kirby = kirby();

    $this->roots    = new Roots(dirname(__DIR__));
    $this->registry = new Registry($this->kirby());

  }

  public function register() {

    $kirby = $this->kirby();

    // $kirby->set('page::method', 'elements', function($name = null) {
    //
    // });
    //
    // $kirby->set('page::method', 'hasElements', function($name = null) {
    //
    // });
    //
    // $kirby->set('page::method', 'isElement', function($name = null) {
    //
    // });

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

  public function kirby() {
    return $this->kirby;
  }

  public function roots() {
    return $this->roots;
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

  }

  public static function layout($type, $data = array()) {

    $class = $type . 'layout';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' layout is missing.');
    }

    $layout = new $class($type);

    foreach($data as $key => $val) {
      if(!is_string($key) || str::length($key) === 0) continue;
      $layout->{$key} = $val;
    }

    return $layout;

  }

  public static function action($type, $data = array()) {

    $class = $type . 'action';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' action is missing.');
    }

    $action = new $class($type);

    foreach($data as $key => $val) {
      if(!is_string($key) || str::length($key) === 0) continue;
      $action->{$key} = $val;
    }

    return $action;

  }

  /**
   * Install a new entry in the registry
   */
  public function set() {
    return call_user_func_array([$this->registry, 'set'], func_get_args());
  }

  /**
   * Retrieve an entry from the registry
   */
  public function get() {
    return call_user_func_array([$this->registry, 'get'], func_get_args());
  }

}
