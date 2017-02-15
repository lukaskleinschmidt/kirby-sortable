<?php

class CopyAction extends BaseAction {

  public $icon  = 'copy';
  public $class = 'sortable__action sortable__action--copy';
  public $label = 'field.sortable.copy';

  public function routes() {
    return array(
      array(
        'pattern' => '/',
        'method'  => 'POST|GET',
        'action'  => 'save',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {

    $content = parent::content();
    $content->data('modal', true);

    return $content;

  }

}
