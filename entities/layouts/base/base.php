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

  public function counter() {

    $page = $this->page();

    if(!$page->isVisible() || !$this->limit()) {
      return null;
    }

    $children = $this->field()->children()->filterBy('template', $page->intendedTemplate());
    $index    = $children->visible()->indexOf($page) + 1;
    $limit    = $this->limit();

    $counter = new Brick('span');
    $counter->addClass('module__counter');
    $counter->html('( ' . $index . ' / ' . $limit . ' )');

    return $counter;

  }

  public function action($type, $data = array()) {
    $data = a::update($data, ['entity' => $this]);
    return $this->field()->action($type, $data);
  }

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['entity' => $this], true);
  }

  public function template() {

    $template = new Brick('div');

    $template->addClass('entity');
    $template->attr('data-uid', $this->page()->uid());
    $template->attr('data-visible', $this->page()->isVisible() ? 'true' : 'false');
    $template->append($this->content());
    $template->append($this->field()->input($this->page()->uid()));

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
