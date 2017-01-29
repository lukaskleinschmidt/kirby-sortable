<?php

class DeleteAction extends BaseAction {

  public $icon = 'trash-o';
  public $title = 'field.sortable.delete';

  public function routes() {
    return array(
      array(
        'pattern' => '(:any)',
        'method'  => 'POST|GET',
        'action'  => 'delete',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {

    $content = parent::content();
    $content->attr('href', $this->url() . '/' . $this->page()->uid());
    $content->data('modal', true);

    return $content;

  }

  public function disabled() {
    $page = $this->page();
    return $this->disabled || $page->blueprint()->options()->delete() === false || $page->ui()->delete() === false;
  }

}
