<?php

namespace LukasKleinschmidt\Sortable\Registry;

use Exception;
use Kirby;
use Dir;
use Obj;
use A;
use F;

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
    //
    // $name  = strtolower($name);
    // $files = array();

    if(!$this->kirby->option('debug') || is_dir($root)) {
      foreach(dir::read($root) as $file) {
        static::$variants[f::name($file)][$name] = $root . DS . $file;
      }

      return static::$variants;
      // return static::$variants[$name] = new Obj([
      //   'root'  => $root,
      //   'name'  => $name,
      //   'files' => $files,
      // ]);
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
