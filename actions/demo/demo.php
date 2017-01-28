<?php

class DemoAction extends BaseAction {

  public $icon  = 'star';
  public $title = array(
    'en' => 'Star',
  );

  public function routes() {
    return array(
      array(
        'pattern' => '(:any)',
        'method'  => 'POST|GET',
        'action'  => 'demo',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

}
