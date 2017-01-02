<?php

class DeleteAction extends BaseAction {

  public $icon = 'trash-o';

  public function routes() {
    return array(
      array(
        'pattern' => '(:all)',
        'method'  => 'POST|GET',
        'action'  => 'delete',
        'filter'  => 'auth',
      ),
    );
  }

}
