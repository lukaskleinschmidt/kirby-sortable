<?php

// Load all registerd classes
$sortable = Kirby\Sortable\Sortable::instance();
$sortable->load();

class SortableField extends InputField {

  public $options = array();
  public $variant = '';
  public $layout = 'base';
  public $prefix = '';
  public $parent = '';
  public $limit = false;

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

  public function action($type, $page = null, $layout = null, $data = array()) {
    if(is_null($page)) $page = $this->origin();
    return Kirby\Sortable\Sortable::action($type, $this, $page, $layout, $data);
  }

  public function layout($type, $page, $data = array()) {
    // return 'Lorem';
    return Kirby\Sortable\Sortable::layout($type, $this, $page, $data);
  }

  public function layouts() {

    $layouts = new Brick('div');
    $layouts->addClass('elements__container');

    $numVisible = 0;
    $num = 0;


    foreach($this->entries() as $page) {

      if($page->isVisible()) $numVisible++;
      $num++;

      $data = a::update($this->options($page)->toArray(), array(
        'numVisible' => $numVisible,
        'num' => $num,
      ));

      $layout = $this->layout($this->layout, $page, $data);
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

    return Kirby\Sortable\Sortable::translation($key, $variant);

  }


  // Needs refactoring
  // public function translation() {
  //
  //   // Return from cache if possible
  //   if($this->translation) {
  //     return $this->translation;
  //   }
  //
  //   $root = __DIR__ . DS . 'translations';
  //   $code = panel()->translation()->code();
  //   $variant = $this->variant();
  //
  //   // Base translation
  //   $this->translation = data::read($root . DS . 'en' . DS . 'modules' . '.json');
  //
  //   if(is_file($root . DS . $code . DS . $variant . '.json')) {
  //     $this->translation = a::update($this->translation, data::read($root . DS . $code . DS . $variant . '.json'));
  //   }
  //
  //   // Load translation
  //   l::set($this->translation);
  //
  //   return $this->translation;
  //
  // }
  // Needs refactoring



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

    // $template = Kirby\Sortable\Sortable::instance()->get('template', $this->template);
    $template = $this->root() . DS . 'template.php';

    if(!is_file($template)) {
      $template = __DIR__ . DS . 'template.php';
    }

    $content  = new Brick('div');

    // Sort namespace is used because otherwise there
    // would be a collision with the jquery sortable plugin
    $content->attr('data-field', 'sort');
    $content->attr('data-api', purl($this->model(), 'field/' . $this->name() . '/' . $this->type()));
    $content->addClass('elements');
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

  public function entries() {

		// Return from cache if possible
		if(!is_null($this->entries)) {
      return $this->entries;
    }

    // Filter the modules by valid module
    $entries = $this->origin()->children()->filter(function($page) {
      return str::startsWith($page->intendedTemplate(), $this->prefix());
    });

    // Sort modules
    if($entries->count() && $this->value()) {
      $i = 0;

      $order = a::merge(array_flip($this->value()), array_flip($entries->pluck('uid')));
      $order = array_map(function($value) use(&$i) {
        return $i++;
      }, $order);

      $entries = $entries->find(array_flip($order));
    }

    // Always return a collection
    if(is_a($entries, 'Page')) {
      $page     = $entries;
      $entries = new Children($this->origin());

      $entries->data[$page->id()] = $page;
    }

    return $this->entries = $entries;

  }

  public function counter() {

    if($this->limit()) {

      $counter = new Brick('span');
      $counter->addClass('elements__counter');
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

    return $this->element()
      ->append($this->content())
      ->append($this->help());

  }

}
