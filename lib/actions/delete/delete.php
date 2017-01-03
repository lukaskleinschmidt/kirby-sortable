<?php

class DeleteAction extends BaseAction {

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

  public function isDisabled() {
    $page = $this->page();
    return $page->blueprint()->options()->delete() === false || $page->ui()->delete() === false;
  }

}
