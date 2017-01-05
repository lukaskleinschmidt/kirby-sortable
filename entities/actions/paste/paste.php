<?php

class PasteAction extends BaseAction {

  public $icon = 'paste';
  public $label = [
    'en' => 'Paste',
    'de' => 'Einfügen',
  ];

  public function routes() {
    return array(
      array(
        'pattern' => '/',
        'method'  => 'POST|GET',
        'action'  => 'paste',
        'filter'  => 'auth',
      ),
    );
  }

  public function isDisabled() {
    return $this->field()->origin()->ui()->create() === false;
  }

}
