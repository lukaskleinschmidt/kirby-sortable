<?php

namespace Kirby\Entities;

use Dir;
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

    // set default actions
    foreach(dir::read($this->roots()->actions()) as $name) {
      $this->set('action', $name, $this->roots()->actions() . DS . $name);
    }

    // set default enteties
    foreach(dir::read($this->roots()->entities()) as $name) {
      $this->set('entity', $name, $this->roots()->entities() . DS . $name);
    }

  }

  public function kirby() {
    return $this->kirby;
  }

  public function roots() {
    return $this->roots;
  }

  public function actions() {

    $actions = $this->get('action');
    $classes = [];

    foreach($actions as $name => $action) {
      $classes[$action->class()] = $action->file();
    }

    load($classes);

  }

  public function entities() {

    $entities = $this->get('entity');
    $classes = [];

    foreach($entities as $name => $entity) {
      $classes[$entity->class()] = $entity->file();
    }

    load($classes);

  }

  public static function action($type, $data = array()) {

    $class = $type . 'action';

    // TODO: add proper exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' action is missing.');
    }

    return new $class($data);

  }

  public static function entity($type, $data = array()) {

    $class = $type . 'entity';

    // TODO: add proper exception
    if(!class_exists($class)) {
      throw new Exception('The ' . $type . ' entity is missing.');
    }

    return new $class($data);

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
