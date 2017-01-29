<?php

class DemoLayout extends BaseLayout {

  public $demo = array(
    'en' => 'demo layout',
    'de' => 'demo layout',
  );

  // public function action($type, $data = array()) {
  //   $action = parent::action($type, $data);
  //   return $action->content()->html($action->icon('left') . $action->title());
  // }

  public function demo() {

    $demo = new Brick('h3');
    $demo->data('handle', true);
    $demo->append(i18n($this->demo));

    return $demo;

  }

}
