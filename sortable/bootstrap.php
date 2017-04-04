<?php

load([

  // main class
  'lukaskleinschmidt\\sortable\\sortable' => 'sortable.php',

  // global stuff
  'lukaskleinschmidt\\sortable\\registry' => 'sortable' . DS . 'registry.php',
  'lukaskleinschmidt\\sortable\\roots'    => 'sortable' . DS . 'roots.php',

  // controllers
  'lukaskleinschmidt\\sortable\\controllers\\field'  => 'sortable' . DS . 'controllers' . DS . 'field.php',
  'lukaskleinschmidt\\sortable\\controllers\\action' => 'sortable' . DS . 'controllers' . DS . 'action.php',

], __DIR__ . DS . 'src' );

class_alias('LukasKleinschmidt\\Sortable\\Sortable', 'LukasKleinschmidt\\Sortable');

// TEMP: Added for convenience because those two classes and namespaces were used in v2.3.1 and below
class_alias('LukasKleinschmidt\\Sortable\\Controllers\\Field',  'Kirby\\Sortable\\Controllers\\Field');
class_alias('LukasKleinschmidt\\Sortable\\Controllers\\Action', 'Kirby\\Sortable\\Controllers\\Action');

include(__DIR__ . DS . 'helpers.php');
