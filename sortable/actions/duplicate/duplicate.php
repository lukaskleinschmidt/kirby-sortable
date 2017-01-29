<?php

class DuplicateAction extends BaseAction {

  public $icon = 'clone';
  public $title = 'field.sortable.duplicate';

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

  public function content() {

    $content = parent::content();
    $content->attr('href', $this->url() . '/' . $this->page()->uid() . '/' . ($this->layout()->num() + 1));
    $content->data('action', true);

    return $content;

  }

  public function disabled() {
    return $this->disabled || $this->field()->origin()->ui()->create() === false;
  }

}
