<?php

class DuplicateActionController extends Kirby\Elements\Controllers\Action {

  /**
   * Duplicate a module
   * 
   * @param string $uid
   * @param int $to
   */
  public function duplicate($uid, $to) {

    $modules = $this->field()->children();
    $parent  = $this->field()->origin();
    $page    = $modules->find($uid);
    $uid     = $this->uid($page);

    if($parent->ui()->create() === false) {
      throw new PermissionsException();
    }

    dir::copy($page->root(), $parent->root() . DS . $uid);

    $modules->add($uid);
    $this->sort($uid, $to);
    $this->notify(':)');
    $this->redirect($this->model());

  }

}
