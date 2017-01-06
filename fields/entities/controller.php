<?php

use Kirby\Panel\Event;
use Kirby\Panel\Exceptions\PermissionsException;

class EntitiesFieldController extends Kirby\Panel\Controllers\Field {

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

    $action = Kirby\Entities\Entities::action($type);
    $routes = $action->routes();
    $router = new Router($routes);

    if($route = $router->run($path)) {
      if(is_callable($route->action()) && is_a($route->action(), 'Closure')) {
        return call($route->action(), $route->arguments());
      } else {

        $controllerFile = $action->root() . DS . 'controller.php';
        $controllerName = $type . 'ActionController';

        // TODO: proper error message
        if(!file_exists($controllerFile)) {
          throw new Exception(l('fields.error.missing.controller'));
        }

        require_once($controllerFile);

        // TODO: proper error message
        if(!class_exists($controllerName)) {
          throw new Exception(l('fields.error.missing.class'));
        }

        $controller = new $controllerName($model, $field, $action);

        return call(array($controller, $route->action()), $route->arguments());

      }

    } else {
      // TODO: proper error message
      throw new Exception(l('fields.error.route.invalid'));
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
      $modules = $this->field()->children();
      $value = $modules->not($uid)->pluck('uid');

      // Order modules value
      array_splice($value, $to - 1, 0, $uid);

      if($modules->find($uid)->ui()->visibility() === false) {
        throw new PermissionsException();
      }

      // Update field value
      $this->update($value);
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    // Get current page
    $page = $modules->find($uid);

    // Figure out the correct sort num
    if($page && $page->isVisible()) {
      $collection = new Children($page->parent());

      foreach(array_slice($value, 0, $to - 1) as $id) {
        if($module = $modules->find($id)) {
          $collection->data[$module->id()] = $module;
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

    $templatePrefix = Kirby\Modules\Settings::templatePrefix();
    $length = str::length($templatePrefix);
    $name = str::substr($template, $length);

    // add a unique hash
    $checksum = sprintf('%u', crc32($name . microtime()));
    return $name . '-' . base_convert($checksum, 10, 36);

  }

}
