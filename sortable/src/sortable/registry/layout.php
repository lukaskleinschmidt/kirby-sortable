<?php

namespace LukasKleinschmidt\Sortable\Registry;

use Exception;
use Kirby;
use Obj;
use A;

class Layout extends Kirby\Registry\Entry {

  // Store of registered layouts
	protected static $layouts = [];

	/**
	 * Adds a new layout to the registry
	 *
	 * @param mixed $name
	 * @param string $root
	 */
	public function set($name, $root = null) {

    $name = strtolower($name);
    $file = $root . DS . $name . '.php';

    if(!$this->kirby->option('debug') || (is_dir($root) && is_file($file))) {
      return static::$layouts[$name] = new Obj([
        'root'  => $root,
        'file'  => $file,
        'name'  => $name,
        'class' => $name . 'layout',
      ]);
    }

    throw new Exception('The layout does not exist at the specified path: ' . $root);

	}

  /**
	 * Retreives a registered layout file
	 * If called without params, retrieves all registered layouts
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$layouts;
    }

    return a::get(static::$layouts, $name);

  }

}
