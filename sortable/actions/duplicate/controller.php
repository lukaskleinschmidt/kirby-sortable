<?php

class DuplicateActionController extends Kirby\Sortable\Controllers\Action {

  /**
   * Duplicate a entry
   *
   * @param string $uid
   * @param int $to
   */
  public function duplicate($uid, $to) {

    $entries = $this->field()->entries();
    $parent  = $this->field()->origin();
    $page    = $entries->find($uid);
    $uid     = $this->uid($page);

    if($parent->ui()->create() === false) {
      throw new PermissionsException();
    }

    dir::copy($page->root(), $parent->root() . DS . $uid);

    $entries->add($uid);
    $this->sort($uid, $to);
    $this->notify(':)');
    $this->redirect($this->model());

  }

}
