<?php

load([

  // main class
  'kirby\\elements\\elements'            => 'elements.php',

  // global stuff
  'kirby\\elements\\registry'            => 'registry.php',
  'kirby\\elements\\roots'               => 'roots.php',

  // controllers
  'kirby\\elements\\controllers\\action' => 'controllers' . DS . 'action.php',

], __DIR__ . DS . 'src' );
