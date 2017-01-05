<?php

namespace Kirby\Entities;

use F;
use Dir;
use Str;
use Exception;

class Entities {

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

    $kirby->set('page::method', 'entities', function($name = null) {

    });

    $kirby->set('page::method', 'hasEntities', function($name = null) {

    });

    $kirby->set('page::method', 'isEntity', function($name = null) {

    });

    // set default templates
    foreach(dir::read($this->roots()->templates()) as $name) {
      $this->set('template', f::name($name), $this->roots()->templates() . DS . $name);
    }

    // set default variants
    foreach(dir::read($this->roots()->variants()) as $name) {
      $this->set('variant', f::name($name), $this->roots()->variants() . DS . $name);
    }

    // set default actions
    foreach(dir::read($this->roots()->actions()) as $name) {
      $this->set('action', $name, $this->roots()->actions() . DS . $name);
    }

    // dump($this->get('template'));
    // dump($this->get('snippet'));
    // dump($this->get('action'));

  }

  public function kirby() {
    return $this->kirby;
  }

  public function roots() {
    return $this->roots;
  }

  public function load() {

    $classes = [];

    foreach($this->get('variant') as $name => $variant) {
      $classes[$variant->class()] = $variant->file();
    }

    foreach($this->get('action') as $name => $action) {
      $classes[$action->class()] = $action->file();
    }

    load($classes);

  }

  public static function variant($type, $field, $data = array()) {

    $class = $type . 'variant';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' variant is missing.');
    }

    return new $class($field, $data);

  }

  public static function action($type, $data = array()) {

    $class = $type . 'action';

    // TODO: check exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' action is missing.');
    }

    $action = new $class;

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
