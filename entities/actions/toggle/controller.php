<?php

class ToggleActionController extends Kirby\Entities\Controllers\Action {

  /**
   * Show page
   *
   * @param string $uid
   * @param int $to
   */
  public function show($uid, $to) {

    // Load translation
    $this->field()->translation();

    $modules = $this->field()->modules();
    $page    = $modules->find($uid);

    if($page->ui()->visibility() === false) {
      throw new PermissionsException();
    }

    try {

      // Check module specific limit
      $count = $modules->filterBy('template', $page->intendedTemplate())->visible()->count();
      $limit = $this->field()->options($page)->limit();

      if($limit && $count >= $limit) {
        throw new Exception(l('fields.modules.module.limit'));
      }

      // Check limit
      $count = $modules->visible()->count();
      $limit = $this->field()->limit();

      if($limit && $count >= $limit) {
        throw new Exception(l('fields.modules.limit'));
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

    $page = $this->field()->modules()->find($uid);

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
