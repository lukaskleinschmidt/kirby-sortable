<?php

// load the entities bootstrapper
require(__DIR__ . DS . 'entities' . DS . 'bootstrap.php');

$entities = Kirby\Entities\Entities::instance();
$entities->register();

$kirby->set('field', 'entities', __DIR__ . DS . 'fields' . DS . 'entities');
$kirby->set('field', 'options' , __DIR__ . DS . 'fields' . DS . 'options');
