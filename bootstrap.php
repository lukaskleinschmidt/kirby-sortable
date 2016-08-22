<?php

// Path to language files
$path = __DIR__ . DS . 'languages' . DS;

// Intendet language file
$language = $path . panel()->translation()->code() . '.php';

// Try to load intended language file and fallback to default language
if(is_file($language)) {
  require_once($language);
} else {
  require_once($path . 'en.php');
}

// Define autoloader
load(array(
  'kirby\\field\\modules\\module'     => __DIR__ . DS . 'lib' . DS . 'module.php',
));