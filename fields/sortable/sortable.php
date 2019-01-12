<?php

use LukasKleinschmidt\Sortable;

// Load all registerd classes
sortable()->load();

class SortableField extends InputField {

  public $limit    = false;
  public $parent   = null;
  public $prefix   = null;
  public $layout   = 'base';
  public $variant  = null;
  public $options  = array();
  public $sortable = true;

  // Caches
  protected $entries;
  protected $defaults;
  protected $origin;

  static public $assets = array(
    'js' => array(
      'sortable.js',
    ),
    'css' => array(
      'sortable.css',
    ),
  );

  public function routes() {
    return array(
      array(
        'pattern' => 'action/(:any)/(:all?)',
        'method'  => 'POST|GET',
        'action'  => 'forAction',
        'filter'  => 'auth',
      ),
      array(
        'pattern' => '(:all)/(:all)/sort',
        'method'  => 'POST|GET',
        'action'  => 'sort',
        'filter'  => 'auth',
      ),
    );
  }

  public function parent() {
    return $this->i18n($this->parent);
  }

  public function action($type, $data = array()) {

    $data = a::update($data, array(
      'field' => $this,
      'parent' => $this->origin(),
    ));

    return sortable::action($type, $data);

  }

  public function layout($type, $data = array()) {

    $data = a::update($data, array(
      'field' => $this,
      'parent' => $this->origin(),
    ));

    return sortable::layout($type, $data);

  }

  public function sortable() {

    if ($this->sortable === false) return false;

    foreach($this->entries() as $page) {
      if ($page->event('sort')->isDenied() || $page->event('visibility')->isDenied()) return false;
    }

    return true;
  }

  public function layouts() {

    $layouts = new Brick('div');
    $layouts->addClass('sortable__container');
    $layouts->attr('data-sortable', $this->sortable() ? 'true' : 'false');

    $numVisible = 0;
    $num = 0;

    foreach($this->entries() as $page) {

      if($page->isVisible()) $numVisible++;
      $num++;

      $data = a::update($this->options($page)->toArray(), array(
        'numVisible' => $numVisible,
        'page' => $page,
        'num' => $num,
      ));

      $layout = $this->layout($this->layout, $data);
      $layouts->append($layout);

    }

    return $layouts;

  }

  /**
   * Get translation
   *
   * @param  string $key
   * @param  string $variant
   * @return string
   */
  public function l($key, $variant = null) {

    if(is_null($variant)) {
      $variant = $this->variant();
    }

    return sortable()->translation($key, $variant);

  }

  public function input() {

    $value = func_get_arg(0);
    $input = parent::input();
    $input->attr(array(
      'id'           => $value,
      'name'         => $this->name() . '[]',
      'type'         => 'hidden',
      'value'        => $value,
      'required'     => false,
      'autocomplete' => false,
    ));

    return $input;

  }

  public function defaults() {

    // Return from cache if possible
    if(!is_null($this->defaults)) {
      return $this->defaults;
    }

    if(!$this->options) {
      return $this->defaults = array();
    }

    // Available templates
    $templates = $this->origin()->blueprint()->pages()->template()->pluck('name');

    // Remove template specific options from the defaults
    $defaults = array();

    foreach($this->options as $key => $value) {
      if(in_array($key, $templates)) continue;
      $defaults[$key] = $value;
    }

    return $this->defaults = $defaults;

  }

  public function options($template) {

    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    // Get entry specific options
    $options = a::get($this->options, $template, array());

    return new Obj(a::update($this->defaults(), $options));

  }

  public function content() {

    $template = $this->root() . DS . 'template.php';

    if(!is_file($template)) {
      $template = __DIR__ . DS . 'template.php';
    }

    $content  = new Brick('div');

    // Sort namespace is used because otherwise there
    // would be a collision with the jquery sortable plugin
    $content->attr('data-field', 'sort');
    $content->attr('data-field-extended', $this->type());
    $content->attr('data-api', $this->url());
    $content->addClass('sortable');
    $content->append(tpl::load($template, array('field' => $this)));

    return $content;

  }

  public function origin() {

    // Return from cache if possible
    if($this->origin) {
      return $this->origin;
    }

    $origin = $this->page();

    if($this->parent()) {
      $origin = $origin->find($this->parent());
    }

    if(!is_a($origin, 'Page')) {
      throw new Exception('The parent page could not be found');
    }

    return $this->origin = $origin;

  }

  public function entries() {

		// Return from cache if possible
		if(!is_null($this->entries)) {
      return $this->entries;
    }

    $entries = $this->origin()->children();

    // Filter the entries
    if($entries->count() && $this->prefix()) {
      $entries = $entries->filter(function($page) {
        return str::startsWith($page->intendedTemplate(), $this->prefix());
      });
    }

    // Sort entries
    if($entries->count() && $this->value()) {
      $i = 0;

      $order = array_flip($this->value()) + array_flip($entries->pluck('uid'));
      $order = array_map(function($value) use(&$i) {
        return $i++;
      }, $order);

      $entries = $entries->find(array_flip($order));
    }

    // Always return a collection
    if(is_a($entries, 'Page')) {
      $page = $entries;
      $entries = new Children($this->origin());

      $entries->data[$page->id()] = $page;
    }

    return $this->entries = $entries;

  }

  public function counter() {

    if($this->limit()) {

      $counter = new Brick('span');
      $counter->addClass('sortable__counter');
      $counter->append('( ' . $this->entries()->visible()->count() . ' / ' . $this->limit() . ' )');

      return $counter;
    }

  }

  public function label() {
    return $this->i18n($this->label);
  }

  public function validate() {
    return true;
  }

  public function value() {

    $value = parent::value();
    if(is_array($value)) {
      return $value;
    } else {
      return str::split($value, ',');
    }

  }

  public function result() {

    $result = parent::result();
    return is_array($result) ? implode(', ', $result) : '';

  }

  public function url($action = null) {

    $url = purl($this->model(), 'field/' . $this->name() . '/' . $this->type());

    if(is_null($action)) {
      return $url;
    }

    return $url . '/action/' . $action;

  }

  public function template() {
    return $this->element()
      ->append($this->content())
      ->append($this->help());
  }

}
