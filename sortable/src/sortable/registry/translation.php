<?php

namespace LukasKleinschmidt\Sortable\Registry;

use Exception;
use Kirby;
use Obj;
use A;

class Translation extends Kirby\Registry\Entry {

  // Store of registered translations
	protected static $translations = [];

	/**
	 * Adds a new translation to the registry
	 *
	 * @param mixed $name
	 * @param string $path
	 */
	public function set($name, $path = null) {

    if(!$this->kirby->option('debug') || is_file($path)) {
      return static::$translations[$name] = $path;
    }

    throw new Exception('The translation does not exist at the specified path: ' . $root);

	}

  /**
	 * Retreives a registered translation file
	 * If called without params, retrieves all registered translations
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$translations;
    }

    return a::get(static::$translations, $name);

  }

}
