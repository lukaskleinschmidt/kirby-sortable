<?php

namespace LukasKleinschmidt\Sortable\Controllers;

use Str;
use Dir;
use Router;
use Children;
use Kirby\Panel\Event;
use Kirby\Panel\Models\Page\Blueprint;
use Kirby\Panel\Exceptions\PermissionsException;
use LukasKleinschmidt\Sortable;

class Field extends \Kirby\Panel\Controllers\Field {

  /**
   * Initiates a action controller
   *
   * @param  string $type
   * @param  string $path
   * @return mixed
   */
  public function forAction($type, $path = '') {

    $model = $this->model();
    $field = $this->field();

    $action = sortable::action($type);
    $routes = $action->routes();
    $router = new Router($routes);

    if($route = $router->run($path)) {
      if(is_callable($route->action()) && is_a($route->action(), 'Closure')) {
        return call($route->action(), $route->arguments());
      } else {

        $controllerFile = $action->root() . DS . 'controller.php';
        $controllerName = $type . 'ActionController';

        if(!file_exists($controllerFile)) {
          throw new Exception('The action controller file is missing');
        }

        require_once($controllerFile);

        if(!class_exists($controllerName)) {
          throw new Exception('The action controller class is missing');
        }

        $controller = new $controllerName($model, $field, $action);

        return call(array($controller, $route->action()), $route->arguments());

      }

    } else {
      throw new Exception('Invalid action route');
    }

  }

  /**
   * Update field value and sort number
   *
   * @param string $uid
   * @param int $to
   */
  public function sort($uid, $to) {

    try {
      $entries = $this->field()->entries();
      $value = $entries->not($uid)->pluck('uid');

      // Order entries value
      array_splice($value, $to - 1, 0, $uid);

      if($entries->find($uid)->ui()->visibility() === false) {
        throw new PermissionsException();
      }

      // Update field value
      $this->update($value);
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    // Get current page
    $page = $entries->find($uid);

    // Figure out the correct sort num
    if($page && $page->isVisible()) {
      $collection = new Children($page->parent());

      foreach(array_slice($value, 0, $to - 1) as $id) {
        if($entry = $entries->find($id)) {
          $collection->data[$entry->id()] = $entry;
        }
      }

      try {
        // Sort the page
        $page->sort($collection->visible()->count() + 1);
      } catch(Exception $e) {
        $this->alert($e->getMessage());
      }
    }

  }

  /**
   * Copy a page to a new location
   *
   * @param object $page
   * @param object $to
   * @return object
   */
  public function copy($page, $to) {

    $template  = $page->intendedTempalte();
    $blueprint = new Blueprint($template);
    $parent    = $to;
    $data      = array();
    $uid       = $this->uid($page);

    foreach($blueprint->fields(null) as $key => $field) {
      $data[$key] = $field->default();
    }

    $data  = array_merge($data, $page->content()->toArray());
    $event = $parent->event('create:action', [
      'parent'    => $parent,
      'template'  => $template,
      'blueprint' => $blueprint,
      'uid'       => $uid,
      'data'      => $data
    ]);

    $event->check();

    // Actually copy the page
    dir::copy($page->root(), $parent->root() . DS . $uid);

    $page = $parent->children()->find($uid);

    if(!$page) {
      throw new Exception(l('pages.add.error.create'));
    }

    kirby()->trigger($event, $page);

    return $page;

  }

  /**
   * Update the field value
   *
   * @param array $value
   */
  public function update($value) {

    try {
      $this->model()->update(array(
        $this->field()->name() => implode(', ', $value)
      ));
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

  }

  /**
   * Create unique uid
   *
   * @param  string $template
   * @return string
   */
  public function uid($template) {

    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    $prefix = $this->field()->prefix();

    if(strpos($template, $prefix) !== false) {
      $length = str::length($prefix);
      $template = str::substr($template, $length);
    }

    // add a unique hash
    $checksum = sprintf('%u', crc32($template . microtime()));
    return $template . '-' . base_convert($checksum, 10, 36);

  }


}
