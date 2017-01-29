<?php

// Make sure that the Modules plugin is loaded
$kirby->plugin('sortable');

if(!function_exists('sortable')) return;

$kirby->set('field', 'demo', __DIR__ . DS . 'fields' . DS . 'demo');

$sortable = sortable();
$sortable->set('action', 'demo', __DIR__ . DS . 'actions'. DS . 'demo');
$sortable->set('layout', 'demo', __DIR__ . DS . 'layouts' . DS . 'demo');
$sortable->set('variant', 'demo', __DIR__ . DS . 'variants' . DS . 'demo');
