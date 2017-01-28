<?php

class ToggleActionController extends Kirby\Sortable\Controllers\Action {

  /**
   * Show page
   *
   * @param string $uid
   * @param int $to
   */
  public function show($uid, $to) {

    $modules = $this->field()->entries();
    $page    = $modules->find($uid);

    if($page->ui()->visibility() === false) {
      throw new PermissionsException();
    }

    try {

      // Check module specific limit
      $count = $modules->filterBy('template', $page->intendedTemplate())->visible()->count();
      $limit = $this->field()->options($page)->limit();

      if($limit && $count >= $limit) {
        throw new Exception($this->field()->l('fields.sortable.limit.template'));
      }

      // Check limit
      $count = $modules->visible()->count();
      $limit = $this->field()->limit();

      if($limit && $count >= $limit) {
        throw new Exception($this->field()->l('fields.sortable.limit'));
      }

      $page->sort($to);
      $this->notify(':)');

    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($this->model());

  }

  /**
   * Hide page
   *
   * @param string $uid
   */
  public function hide($uid) {

    $page = $this->field()->entries()->find($uid);

    if($page->ui()->visibility() === false) {
      throw new PermissionsException();
    }

    try {
      $page->hide();
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($this->model());

  }

}
