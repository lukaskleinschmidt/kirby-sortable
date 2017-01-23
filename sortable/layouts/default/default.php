<?php

class DefaultLayout extends BaseLayout {

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['layout' => $this], true);
  }

}
