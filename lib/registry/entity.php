<?php

namespace Kirby\Entities\Registry;

use Exception;
use Kirby;
use Obj;
use A;

class Entity extends Kirby\Registry\Entry {

  // Store of registered entities
	protected static $entities = [];

	/**
	 * Adds a new entity to the registry
	 *
	 * @param mixed $name
	 * @param string $root
	 */
	public function set($name, $root = null) {

    // if(!$this->kirby->option('debug') || is_dir($path)) {
    //   return static::$entities[$name] = $path;
    // }

    $name = strtolower($name);
    $file = $root . DS . $name . '.php';

    if(!$this->kirby->option('debug') || (is_dir($root) && is_file($file))) {
      return static::$entities[$name] = new Obj([
        'root'  => $root,
        'file'  => $file,
        'name'  => $name,
        'class' => $name . 'entity',
      ]);
    }

    throw new Exception('The entity does not exist at the specified path: ' . $path);

	}

  /**
	 * Retreives a registered entity file
	 * If called without params, retrieves a list of entity names
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$entities;
    }

    return a::get(static::$entities, $name);

  }

}
