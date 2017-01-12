<?php

class BaseLayout {

  public $type;

  public function root() {
    $obj = new ReflectionClass($this);
    return dirname($obj->getFileName());
  }

  public function __construct($type) {
    $this->type = $type;
  }

  public function __call($method, $arguments) {
    return isset($this->$method) ? $this->$method : null;
  }

  public function type() {
    return $this->type;
  }

  public function input() {
    return $this->field()->input($this->page()->uid());
  }

  public function counter() {

    $page = $this->page();

    if(!$page->isVisible() || !$this->limit()) {
      return null;
    }

    $children = $this->field()->children()->filterBy('template', $page->intendedTemplate());
    $index    = $children->visible()->indexOf($page) + 1;
    $limit    = $this->limit();

    $counter = new Brick('span');
    $counter->addClass('element__counter');
    $counter->html('( ' . $index . ' / ' . $limit . ' )');

    return $counter;

  }

  public function icon($position = '') {
    return $this->page()->icon($position);
  }

  public function blueprint() {
    return $this->page()->blueprint();
  }

  public function title() {
    return $this->page()->title();
  }

  public function action($type, $data = array()) {
    $data = a::update($data, ['element' => $this]);
    return $this->field()->action($type, $data);
  }

  public function template() {

    $template = new Brick('div');

    $template->addClass('element');
    $template->attr('data-uid', $this->page()->uid());
    $template->attr('data-visible', $this->page()->isVisible() ? 'true' : 'false');
    $template->append($this->content());
    $template->append($this->input());

    return $template;

  }

  public function __toString() {
    try {
      return (string)$this->template();
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}
