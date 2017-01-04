<?php

class DeleteAction extends BaseAction {

  public function routes() {
    return array(
      array(
        'pattern' => '(:all)',
        'method'  => 'POST|GET',
        'action'  => 'add',
        'filter'  => 'auth',
      ),
    );
  }

  public function isDisabled() {
    return $page->ui()->create() === false;
  }

}
