<?php

class DuplicateAction extends BaseAction {

  public $icon = 'clone';
  public $title = 'fields.sortable.duplicate';

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
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function disabled() {
    return $this->disabled || $this->field()->origin()->ui()->create() === false;
  }

}
