<?php

class EditAction extends BaseAction {

  public $icon = 'pencil';
  public $title = [
    'en' => 'Edit',
    'de' => 'Bearbeiten',
  ];

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function isDisabled() {
    return $this->page()->ui()->read() === false;
  }

}
