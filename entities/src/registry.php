<?php

namespace Kirby\Entities;

// Kirby dependencies
use Exception;
use Kirby;

class Registry extends Kirby\Registry {

  /**
   * @param Kirby $kirby
   */
  public function __construct(Kirby $kirby) {

    $this->kirby = $kirby;

    // start the registry entry autoloader
    load([
      'kirby\\entities\\registry\\template' => __DIR__ . DS . 'registry' . DS . 'template.php',
      'kirby\\entities\\registry\\layout'   => __DIR__ . DS . 'registry' . DS . 'layout.php',
      'kirby\\entities\\registry\\action'   => __DIR__ . DS . 'registry' . DS . 'action.php',
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

    $class = 'kirby\\entities\\registry\\' . $type;

    if(!class_exists('kirby\\entities\\registry\\' . $type)) {
      throw new Exception('Unsupported registry entry type: ' . $type);
    }

    return new $class($this);

  }


}
