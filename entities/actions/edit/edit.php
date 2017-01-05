<?php

class EditAction extends BaseAction {

  public $icon = 'pencil';
  public $title = [
    'en' => 'Edit',
    'de' => 'Bearbeiten',
  ];

  public function isDisabled() {
    return $this->page()->ui()->read() === false;
  }

}
