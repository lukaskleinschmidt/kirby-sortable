<?php

class RedirectField extends BaseField {

  public $redirect;

  public function template() {

    $redirect = $this->redirect();

    if(is_null($redirect)) {
      return go(purl($this->page()->parent(), 'edit'));
    }

    $page = panel()->page($redirect);

    if(is_null($page)) {
      return go(purl());
    }

    return go(purl($page));

  }

}
