<?php

class AddAction extends BaseAction {

  public $icon  = 'plus-circle';
  public $label = 'field.sortable.add';

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

    $content = parent::content();
    $content->addClass('elements__action elements__action--add');
    $content->data('modal', true);

    return $content;

  }

  public function disabled() {
    return $this->disabled || $this->parent()->ui()->create() === false;
  }

}
