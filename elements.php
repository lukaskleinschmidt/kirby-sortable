<?php

// load the elements bootstrapper
require(__DIR__ . DS . 'elements' . DS . 'bootstrap.php');

$elements = Kirby\Elements\Elements::instance();
$elements->register();

$kirby->set('field', 'elements', __DIR__ . DS . 'fields' . DS . 'elements');
$kirby->set('field', 'options' , __DIR__ . DS . 'fields' . DS . 'options');
$kirby->set('field', 'redirect', __DIR__ . DS . 'fields' . DS . 'redirect');
