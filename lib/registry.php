<?php

namespace Kirby\Subpages;

// Kirby dependencies
use Exception;
use Kirby;

class Registry extends Kirby\Registry {

  public static $instance;

  /**
	 * Returns the singleton class instance
	 *
	 * @return Registry
	 */
	public static function instance() {
		if(!is_null(static::$instance)) return static::$instance;
		return static::$instance = new static();
	}

  /**
   * @param Kirby $kirby
   */
  public function __construct() {

    $this->kirby = kirby();

    // start the registry entry autoloader
    load([
      'kirby\\subpages\\registry\\translation' => __DIR__ . DS . 'registry' . DS . 'translation.php',
      'kirby\\subpages\\registry\\template'    => __DIR__ . DS . 'registry' . DS . 'template.php',
      'kirby\\subpages\\registry\\action'      => __DIR__ . DS . 'registry' . DS . 'action.php',
    ]);

  }

  /**
   * Returns a registry entry object by type
   *
   * @param string $type
   * @param string $subtype
   * @return Kirby\Registry\Entry
   */
  public function entry($type, $subtype = null) {

    $class = 'kirby\\subpages\\registry\\' . $type;

    if(!class_exists('kirby\\subpages\\registry\\' . $type)) {
      throw new Exception('Unsupported registry entry type: ' . $type);
    }

    return new $class($this);

  }


}
