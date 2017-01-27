<?php

class AddAction extends BaseAction {

  public $icon  = 'plus-circle';
  public $class = 'elements__action elements__action--add';
  public $label = [
    'en' => 'Add',
    'de' => 'Hinzufügen',
  ];

  public function routes() {
    return array(
      array(
        'pattern' => '/',
        'method'  => 'POST|GET',
        'action'  => 'add',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function disabled() {
    return $this->disabled || $this->parent()->ui()->create() === false;
  }

}
