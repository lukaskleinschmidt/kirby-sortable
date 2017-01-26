<?php

namespace Kirby\Sortable;

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

  protected $loaded = false;

  public function __construct() {

    $this->kirby = kirby();

    $this->roots       = new Roots(dirname(__DIR__));
    $this->registry    = new Registry($this->kirby());
    // $this->translation = new Translation($this->roots()->translations());

  }

  public static function instance() {
    if(!is_null(static::$instance)) return static::$instance;
    return static::$instance = new static();
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

  public static function translation($key, $variant = null) {
    return;
  }

  public function register() {

    foreach(dir::read($this->roots()->translations()) as $name) {
      if(is_dir($root = $this->roots()->translations() . DS . $name)) {
        $this->set('translation', $name, $root);
      }
    }

    foreach(dir::read($this->roots()->layouts()) as $name) {
      $this->set('layout', $name, $this->roots()->layouts() . DS . $name);
    }

    foreach(dir::read($this->roots()->actions()) as $name) {
      $this->set('action', $name, $this->roots()->actions() . DS . $name);
    }

  }

  public function load() {

    dump($this->get('translation'));

    dump(dir::read($this->roots()->translations()));

    $translation = $this->roots()->translations() . DS . 'en.php';
    dump(data::read($translation));

    // if(is_file($root . DS . $code . DS . $variant . '.json')) {
    //   $this->translation = a::update($this->translation, data::read($root . DS . $code . DS . $variant . '.json'));
    // }
    //
    //   // Load translation
    //   l::set($this->translation);

    // foreach($this->get('translation') as $name => $translation) {
    //   dump($translation);
    // }

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
