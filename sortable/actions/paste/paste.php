<?php

class PasteAction extends BaseAction {

  public $icon  = 'paste';
  public $label = 'field.sortable.paste';

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

  public function content() {

    $content = parent::content();
    $content->addClass('elements__action elements__action--paste');
    $content->data('modal', true);

    return $content;

  }

  public function disabled() {
    return $this->disabled || $this->parent()->ui()->create() === false;
  }

}
