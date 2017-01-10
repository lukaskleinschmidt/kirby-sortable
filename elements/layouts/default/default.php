<?php

class DefaultLayout extends BaseLayout {

  static public $assets = array(
    'js' => array(
      'page.js',
    ),
    'css' => array(
      'page.css',
    ),
  );

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['element' => $this], true);
  }

}
