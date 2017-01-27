<?php

// if(!function_exists('panel')) return;

// load the sortable bootstrapper
require(__DIR__ . DS . 'sortable' . DS . 'bootstrap.php');

sortable()->register();

$kirby->set('field', 'sortable', __DIR__ . DS . 'fields' . DS . 'sortable');
$kirby->set('field', 'options' , __DIR__ . DS . 'fields' . DS . 'options');
$kirby->set('field', 'redirect', __DIR__ . DS . 'fields' . DS . 'redirect');
$kirby->set('field', 'modules', __DIR__ . DS . 'fields' . DS . 'modules');
