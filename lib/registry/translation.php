<?php

namespace Kirby\Subpages\Registry;

use Exception;
use Kirby;
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
	public function set($name, $path) {

    if(is_array($name)) {
      foreach($name as $n => $p) $this->set($n, $p);
      return;
    }

    if(!$this->kirby->option('debug') || is_dir($path)) {
      return static::$translations[$name] = $path;
    }

    throw new Exception('The translation does not exist at the specified path: ' . $path);

	}

  /**
	 * Retreives a registered translation file
	 * If called without params, retrieves a list of translation names
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
