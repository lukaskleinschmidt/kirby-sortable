<?php

namespace Kirby\Subpages\Registry;

use Exception;
use Kirby;
use A;

class Action extends Kirby\Registry\Entry {

  // Store of registered actions
	protected static $actions = [];

	/**
	 * Adds a new action to the registry
	 *
	 * @param mixed $name
	 * @param string $path
	 */
	public function set($name, $path = null) {

    if(!$this->kirby->option('debug') || is_dir($path)) {
      return static::$actions[$name] = $path;
    }

    throw new Exception('The action does not exist at the specified path: ' . $path);

	}

  /**
	 * Retreives a registered action file
	 * If called without params, retrieves a list of action names
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
