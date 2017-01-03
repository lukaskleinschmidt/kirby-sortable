<?php

load([
  'kirby\\entities\\entities' => __DIR__ . DS . 'lib' . DS . 'entities.php',
  'kirby\\entities\\registry' => __DIR__ . DS . 'lib' . DS . 'registry.php',
  'kirby\\entities\\plugins'  => __DIR__ . DS . 'lib' . DS . 'plugins.php',
  'kirby\\entities\\roots'    => __DIR__ . DS . 'lib' . DS . 'roots.php',
]);

$kirby->set('field', 'entities', __DIR__ . DS . 'fields' . DS . 'entities');
$kirby->set('field', 'options' , __DIR__ . DS . 'fields' . DS . 'options');

// /**
//  * Returns the Entities class singleton
//  *
//  * @return Entities
//  */
// function entities() {
//   return Kirby\Entities\Entities::instance();
// }

$entities = Kirby\Entities\Entities::instance();
$entities->register();

// $entities->set('action', 'test', __DIR__ . DS . 'lib' . DS . 'actions' . DS . 'delete' );

// $entities->load();

// dump($entities->get('action'));
// dump($entities->get('entity'));
