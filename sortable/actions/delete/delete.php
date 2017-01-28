<?php

class DeleteAction extends BaseAction {

  public $icon = 'trash-o';
  public $title = 'fields.sortable.delete';

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
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function disabled() {
    $page = $this->page();
    return $this->disabled || $page->blueprint()->options()->delete() === false || $page->ui()->delete() === false;
  }

}
