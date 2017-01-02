<?php

namespace Kirby\Entities;

class Entities {

  static public $instance;

  public $kirby;
  public $registry;

  public static function instance() {
    if(!is_null(static::$instance)) return static::$instance;
    return static::$instance = new static();
  }

  public function __construct() {

    $this->kirby = kirby();

    $this->roots    = new Roots(dirname(__DIR__));
    $this->registry = new Registry($this->kirby());
    // $this->plugins  = new Plugins();

  }

  public function kirby() {
    return $this->kirby;
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
