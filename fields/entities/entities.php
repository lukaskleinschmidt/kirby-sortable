<?php

class EntitiesField extends InputField {

  public $template = 'default';
  public $options = array();
  public $layout = 'default';
  public $prefix = '';
  public $parent = '';
  public $limit = false;

  // Caches
  protected $children;
  protected $defaults;
  protected $origin;

  protected $translation;

  static public $assets = array(
    'js' => array(
      'entities.js',
    ),
    'css' => array(
      'entities.css',
    ),
  );

  public static function setup() {
    Kirby\Entities\Entities::instance()->load();
  }

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

  public function entities() {

    $entities = new Brick('div');
    $entities->addClass('entities__container');

    $field      = $this;
    $numVisible = 0;
    $num        = 0;

    foreach($this->children() as $page) {

      if($page->isVisible()) $numVisible++;
      $num++;

      $data = compact('field', 'page', 'num', 'numVisible');
      $data = a::update($this->options($page)->toArray(), $data);

      $entity = Kirby\Entities\Entities::layout($this->layout(), $data);
      $entities->append($entity);

    }

    return $entities;

  }

  public function hasEntities() {
    return $this->children()->count();
  }

  public function action($type, $data = array()) {
    $data = a::update($data, ['field' => $this, 'type' => $type]);
    return Kirby\Entities\Entities::action($type, $data);
  }


  // Needs refactoring
  public function translation() {

    // Return from cache if possible
    if($this->translation) {
      return $this->translation;
    }

    $root = __DIR__ . DS . 'translations';
    $code = panel()->translation()->code();
    $variant = $this->variant();

    // Base translation
    $this->translation = data::read($root . DS . 'en' . DS . 'modules' . '.json');

    if(is_file($root . DS . $code . DS . $variant . '.json')) {
      $this->translation = a::update($this->translation, data::read($root . DS . $code . DS . $variant . '.json'));
    }

    // Load translation
    l::set($this->translation);

    return $this->translation;

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
    $defaults = array_filter($this->options, function($key) use($templates) {
      return !in_array($key, $templates);
    }, ARRAY_FILTER_USE_KEY);

    return $this->defaults = $defaults;

  }

  public function options($template) {

    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    // Get module specific options
    $options = a::get($this->options, $template, array());

    return new Obj(a::update($this->defaults(), $options));

  }

  public function content() {

    $template = Kirby\Entities\Entities::instance()->get('template', $this->template);

    $content  = new Brick('div');

    $content->addClass('entities');
    $content->attr('data-field', 'entities');
    $content->attr('data-api', purl($this->model(), 'field/' . $this->name() . '/entities'));
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

    return $this->origin = $origin;

  }

  public function children() {

		// Return from cache if possible
		if(!is_null($this->children)) {
      return $this->children;
    }

    // Filter the modules by valid module
    $children = $this->origin()->children()->filter(function($page) {
      return str::startsWith($page->intendedTemplate(), $this->prefix());
    });

    // Sort modules
    if($children->count() && $this->value()) {
      $i = 0;

      $order = a::merge(array_flip($this->value()), array_flip($children->pluck('uid')));
      $order = array_map(function($value) use(&$i) {
        return $i++;
      }, $order);

      $children = $children->find(array_flip($order));
    }

    // Always return a collection
    if(is_a($children, 'Page')) {
      $page     = $children;
      $children = new Children($this->origin());

      $children->data[$page->id()] = $page;
    }

    return $this->children = $children;

  }

  public function label() {

    // Load translation
    $this->translation();

    $label = new Brick('label');
    $label->addClass('label');
    $label->html($this->i18n($this->label));

    if($this->limit()) {
      $label->append(' <span class="modules__counter">( ' . $this->children()->visible()->count() . ' / ' . $this->limit() . ' )</span>');
    }

    return $label;

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

  public function url($action, $params = array()) {

    if($params) {
      $action = $action . '/' . implode('/', $params);
    }

    return purl($this->model(), implode('/', array(
      'field',
      $this->name(),
      $this->type(),
      'action',
      $action
    )));

  }

  public function template() {

    if(!$this->origin()) {
      // TODO: Add proper error
      return $this->element();
    }

    return $this->element()
      ->append($this->content())
      ->append($this->help());

  }

}
