<?php

namespace LukasKleinschmidt\Sortable;

use A;
use F;
use L;
use Dir;
use Str;
use Data;
use Exception;

class Sortable {

  static public $instance;

  public $kirby;
  public $roots;
  public $registry;
  public $variants;

  public function __construct() {

    $this->kirby = kirby();

    $this->roots    = new Roots(dirname(__DIR__));
    $this->registry = new Registry($this->kirby());

  }

  public static function instance() {
    if(!is_null(static::$instance)) return static::$instance;
    return static::$instance = new static();
  }

  public static function layout($type, $data = array()) {

    $class = $type . 'layout';

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

  public function translation($key, $variant = null) {

    // IDEA: outsource into own class
    // $variants = $this->variants();
    // return $variants->get($key, $variant, l::get($key));

    if(!is_null($variant) && $variant = a::get($this->variants, $variant)) {
      return a::get($variant, $key, l::get($key, $key));
    }

    return l::get($key, $key);

  }

  public function register() {

    foreach(dir::read($this->roots()->translations()) as $name) {
      $this->set('translation', f::name($name), $this->roots()->translations() . DS . $name);
    }

    foreach(dir::read($this->roots()->variants()) as $name) {
      $this->set('variant', $name, $this->roots()->variants() . DS . $name);
    }

    foreach(dir::read($this->roots()->layouts()) as $name) {
      $this->set('layout', $name, $this->roots()->layouts() . DS . $name);
    }

    foreach(dir::read($this->roots()->actions()) as $name) {
      $this->set('action', $name, $this->roots()->actions() . DS . $name);
    }

  }

  public function load() {

    $code = panel()->translation()->code();

    if(!$path = $this->get('translation', $code)) {
      $path = $this->get('translation', 'en');
    }

    l::set(data::read($path));

    if($variants = $this->get('variant', $code)) {
      foreach($variants as $name => $path) {
        $this->variants[$name] = data::read($path);
      }
    }

    $classes = [];

    foreach($this->get('layout') as $name => $layout) {
      $classes[$layout->class()] = $layout->file();
    }

    foreach($this->get('action') as $name => $action) {
      $classes[$action->class()] = $action->file();
    }

    load($classes);

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
