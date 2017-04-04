<?php

namespace LukasKleinschmidt\Sortable\Registry;

use Exception;
use Kirby;
use Obj;
use A;

class Action extends Kirby\Registry\Entry {

  // Store of registered actions
	protected static $actions = [];

	/**
	 * Adds a new action to the registry
	 *
	 * @param mixed $name
	 * @param string $root
	 */
	public function set($name, $root = null) {

    $name = strtolower($name);
    $file = $root . DS . $name . '.php';

    if(!$this->kirby->option('debug') || (is_dir($root) && is_file($file))) {
      return static::$actions[$name] = new Obj([
        'root'  => $root,
        'file'  => $file,
        'name'  => $name,
        'class' => $name . 'action',
      ]);
    }

    throw new Exception('The action does not exist at the specified path: ' . $root);

	}

  /**
	 * Retreives a registered action file
	 * If called without params, retrieves all registered actions
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$actions;
    }

    return a::get(static::$actions, $name);

  }

}
