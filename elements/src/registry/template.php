<?php

namespace Kirby\Elements\Registry;

use Exception;
use Kirby;
use A;

class Template extends Kirby\Registry\Entry {

  // Store of registered templates
	protected static $templates = [];

	/**
	 * Adds a new template to the registry
	 *
	 * @param mixed $name
	 * @param string $path
	 */
	public function set($name, $path = null) {

    if(!$this->kirby->option('debug') || is_file($path)) {
      return static::$templates[$name] = $path;
    }

    throw new Exception('The template does not exist at the specified path: ' . $path);

	}

  /**
	 * Retreives a registered template file
	 * If called without params, retrieves all registered templates
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$templates;
    }

    return a::get(static::$templates, $name);

  }

}
