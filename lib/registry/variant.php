<?php

namespace Kirby\Entities\Registry;

use Exception;
use Kirby;
use Obj;
use A;

class Variant extends Kirby\Registry\Entry {

  // Store of registered variants
	protected static $variants = [];

	/**
	 * Adds a new variant to the registry
	 *
	 * @param mixed $name
	 * @param string $root
	 */
	public function set($name, $root = null) {

    $name = strtolower($name);
    $file = $root . DS . $name . '.php';

    if(!$this->kirby->option('debug') || (is_dir($root) && is_file($file))) {
      return static::$variants[$name] = new Obj([
        'root'  => $root,
        'file'  => $file,
        'name'  => $name,
        'class' => $name . 'variant',
      ]);
    }

    throw new Exception('The variant does not exist at the specified path: ' . $root);

	}

  /**
	 * Retreives a registered variant file
	 * If called without params, retrieves all registered variants
	 *
	 * @param  string $name
	 * @return mixed
	 */
  public function get($name = null) {

    if(is_null($name)) {
      return static::$variants;
    }

    return a::get(static::$variants, $name);

  }

}
