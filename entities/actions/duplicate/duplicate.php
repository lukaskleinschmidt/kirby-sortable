<?php

class DuplicateAction extends BaseAction {

  public $icon = 'clone';
  public $title = [
    'en' => 'Duplicate',
    'de' => 'Duplizieren',
  ];

  public function routes() {
    return array(
      array(
        'pattern' => '(:any)/(:any)',
        'method'  => 'POST|GET',
        'action'  => 'duplicate',
        'filter'  => 'auth',
      ),
    );
  }

  public function isDisabled() {
    return $this->field()->origin()->ui()->create() === false;
  }

}
