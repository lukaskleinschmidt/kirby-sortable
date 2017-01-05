<?php

load([

  // main class
  'kirby\\entities\\entities'            => 'entities.php',

  // global stuff
  'kirby\\entities\\registry'            => 'registry.php',
  'kirby\\entities\\plugins'             => 'plugins.php',
  'kirby\\entities\\roots'               => 'roots.php',

  // controllers
  'kirby\\entities\\controllers\\action' => 'controllers' . DS . 'action.php',

], __DIR__ . DS . 'src' );
