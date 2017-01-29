<?php

class DemoAction extends BaseAction {

  public $icon  = 'star';
  public $title = array(
    'en' => 'Star',
    'en' => 'Stern',
  );

  public function routes() {
    return array(
      array(
        'pattern' => '(:any)',
        'method'  => 'POST|GET',
        'action'  => 'demo',
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
}
