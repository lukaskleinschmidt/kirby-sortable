<?php

namespace Kirby\Sortable\Controllers;

use Str;
use Router;
use Children;
use Kirby\Panel\Event;
use Kirby\Panel\Exceptions\PermissionsException;
use Kirby\Sortable\Sortable;

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
          throw new Exception(l('field.sortable.error.missing.controller'));
        }

        require_once($controllerFile);

        if(!class_exists($controllerName)) {
          throw new Exception(l('field.sortable.error.missing.class'));
        }

        $controller = new $controllerName($model, $field, $action);

        return call(array($controller, $route->action()), $route->arguments());

      }

    } else {
      throw new Exception(l('field.sortable.error.route.invalid'));
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
