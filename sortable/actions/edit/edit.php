<?php

class EditAction extends BaseAction {

  public $icon = 'pencil';
  public $title = 'field.sortable.edit';

  public function content() {

    $content = parent::content();
    $content->attr('href', $this->page()->url('edit'));

    return $content;

  }

  public function disabled() {
    return $this->disabled || $this->page()->ui()->read() === false;
  }

}
