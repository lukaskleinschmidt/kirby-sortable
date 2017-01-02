<?php

namespace Kirby\Subpages\Registry;

use Exception;
use Kirby;
use A;

class Template extends Kirby\Registry\Entry {

  // Store of registered templates
	protected static $templates = [];

	/**
	 * Adds a new templates to the registry
	 *
	 * @param mixed $name
	 * @param string $path
	 */
	public function set($name, $path) {

    if(is_array($name)) {
      foreach($name as $n => $p) $this->set($n, $p);
      return;
    }

    if(!$this->kirby->option('debug') || file_exists($path)) {
      return static::$templates[$name] = $path;
    }

    throw new Exception('The template does not exist at the specified path: ' . $path);

	}

  /**
	 * Retreives a registered template file
	 * If called without params, retrieves a list of template names
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
