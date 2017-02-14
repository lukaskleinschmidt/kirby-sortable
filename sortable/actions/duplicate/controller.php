<?php

use Kirby\Panel\Models\Page\Blueprint;

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

    $template  = $page->intendedTempalte();
    $blueprint = new Blueprint($template);
    $data      = array();

    foreach($blueprint->fields(null) as $key => $field) {
      $data[$key] = $field->default();
    }

    $data  = array_merge($data, $page->content()->toArray());
    $event = $parent->event('create:action', [
      'parent'    => $parent,
      'template'  => $template,
      'blueprint' => $blueprint,
      'uid'       => $uid,
      'data'      => $data
    ]);

    $event->check();

    dir::copy($page->root(), $parent->root() . DS . $uid);

    $page = $parent->children()->find($uid);

    if(!$page) {
      throw new Exception(l('pages.add.error.create'));
    }

    kirby()->trigger($event, $page);

    $entries->add($uid);
    $this->sort($uid, $to);
    $this->notify(':)');
    $this->redirect($this->model());

  }

}
