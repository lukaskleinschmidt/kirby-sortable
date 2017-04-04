<?php

namespace LukasKleinschmidt\Sortable;

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
      'lukaskleinschmidt\\sortable\\registry\\translation' => __DIR__ . DS . 'registry' . DS . 'translation.php',
      'lukaskleinschmidt\\sortable\\registry\\variant'     => __DIR__ . DS . 'registry' . DS . 'variant.php',
      'lukaskleinschmidt\\sortable\\registry\\layout'      => __DIR__ . DS . 'registry' . DS . 'layout.php',
      'lukaskleinschmidt\\sortable\\registry\\action'      => __DIR__ . DS . 'registry' . DS . 'action.php',
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

    $class = 'lukaskleinschmidt\\sortable\\registry\\' . $type;

    if(!class_exists('lukaskleinschmidt\\sortable\\registry\\' . $type)) {
      throw new Exception('Unsupported registry entry type: ' . $type);
    }

    return new $class($this);

  }


}
