<?php

load([

  // main class
  'kirby\\sortable\\sortable'            => 'sortable.php',

  // global stuff
  'kirby\\sortable\\registry'            => 'sortable' . DS . 'registry.php',
  'kirby\\sortable\\roots'               => 'sortable' . DS . 'roots.php',

  // controllers
  'kirby\\sortable\\controllers\\field'  => 'sortable' . DS . 'controllers' . DS . 'field.php',
  'kirby\\sortable\\controllers\\action' => 'sortable' . DS . 'controllers' . DS . 'action.php',

], __DIR__ . DS . 'src' );
