<?php

load([
  'kirby\\subpages\\registry' => __DIR__ . DS . 'lib' . DS . 'registry.php',
]);

$registry = Kirby\Subpages\Registry::instance();
$registry->set('action', 'base', __DIR__ . DS . 'actions' . DS . 'base' );
$registry->set('action', 'delete', __DIR__ . DS . 'actions' . DS . 'delete' );

// $registry->set('template', 'default', __DIR__ . DS . 'fields' . DS . 'elements' . DS . 'template.php');
// $registry->set('action', [
//   'duplicate' => __DIR__ . DS . 'fields' . DS . 'elements' . DS . 'actions' . DS . 'duplicate.php',
//   'delete' => __DIR__ . DS . 'fields' . DS . 'elements' . DS . 'actions' . DS . 'delete.php',
//   'toggle' => __DIR__ . DS . 'fields' . DS . 'elements' . DS . 'actions' . DS . 'toggle.php',
//   'edit' => __DIR__ . DS . 'fields' . DS . 'elements' . DS . 'actions' . DS . 'edit.php',
// ]);

$kirby->set('field', 'subpages', __DIR__ . DS . 'fields' . DS . 'subpages');
$kirby->set('field', 'options', __DIR__ . DS . 'fields' . DS . 'options');
