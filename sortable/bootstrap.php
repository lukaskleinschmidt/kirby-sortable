<?php

load([

  // main class
  'kirby\\sortable\\sortable'            => 'sortable.php',

  // global stuff
  'kirby\\sortable\\registry'            => 'registry.php',
  'kirby\\sortable\\roots'               => 'roots.php',

  // controllers
  'kirby\\sortable\\controllers\\field'  => 'controllers' . DS . 'field.php',
  'kirby\\sortable\\controllers\\action' => 'controllers' . DS . 'action.php',

], __DIR__ . DS . 'src' );
