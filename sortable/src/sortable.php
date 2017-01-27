<?php

namespace Kirby\Sortable;

use A;
use F;
use Dir;
use Str;
use Data;
use Exception;

class Sortable {

  static public $instance;

  public $kirby;
  public $roots;
  public $registry;

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

  public static function translation($key, $variant = null) {
    return;
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

    // dump($this->get('translation'));
    // dump($this->get('variant'));

    // $this->variants = new Variants($this->get('variant'));

    $code = panel()->translation()->code();

    // dump(dir::read($this->roots()->translations()));

    // $translation = $this->roots()->translations() . DS . 'en.php';
    // dump(data::read($translation));

    // $this->get('variant', 'modules');

    // if(is_file($root . DS . $code . DS . $variant . '.json')) {
    //   $this->translation = a::update($this->translation, data::read($root . DS . $code . DS . $variant . '.json'));
    // }
    //
    //   // Load translation
    //   l::set($this->translation);

    // foreach($this->get('translation') as $name => $translation) {
    //   dump($translation);
    // }
    //

    foreach($this->get('variant') as $name => $variant) {
      if($file = a::get($variant->files(), $code)) {
        $data = data::read($variant->root() . DS . $file);
        if(is_array($data)) {
          $this->variants[$name] = $data;
        }
      }
    }

    // dump($this->variants);

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
