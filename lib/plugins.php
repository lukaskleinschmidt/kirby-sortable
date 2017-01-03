<?php

namespace Kirby\Entities;

use Dir;

class Plugins {

  public $entites;

  public function __construct(Entities $entities) {

    $this->entities = $entities;

    $this->find('action', $this->entities->roots()->actions());
    $this->load('action');

    $this->find('entity', $this->entities->roots()->entities());
    $this->load('entity');

  }

  public function find($type, $root) {

    // store all entries coming from plugins and
    // load them after the default fields
    $entries = $this->entities->get($type);

    // load the defaults first, because they can be overwritten
    foreach(dir::read($root) as $name) {
      $this->entities->set($type, $name, $root . DS . $name);
    }

    // load the plugin entries again. A bit hacky, but works
    foreach($entries as $name => $entry) {
      $this->entities->set($type, $name, $entry->root());
    }

  }

  public function load() {

    $actions = $this->entities->get('action');
    $actions = $this->entities->get('entity');

  }

}
