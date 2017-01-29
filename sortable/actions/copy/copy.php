<?php

class CopyAction extends BaseAction {

  public $icon  = 'copy';
  public $label = 'field.sortable.copy';

  public function routes() {
    return array(
      array(
        'pattern' => '/',
        'method'  => 'POST|GET',
        'action'  => 'copy',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {

    $content = parent::content();
    $content->addClass('elements__action elements__action--copy');
    $content->data('modal', true);

    return $content;

  }

}
