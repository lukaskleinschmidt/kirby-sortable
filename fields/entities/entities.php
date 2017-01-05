<?php

class EntitiesField extends InputField {

  static protected $entities;
  public $template = 'default';
  public $variant = 'default';
  public $options = array();
  public $limit = false;

  protected $translation;
  protected $defaults;
  protected $modules;
  protected $origin;

  static public $assets = array(
    'js' => array(
      'modules.js',
    ),
    'css' => array(
      'modules.css',
    ),
  );

  public static function setup() {
    static::$entities = Kirby\Entities\Entities::instance();
    static::$entities->load();
  }

  public function hasEntities() {
    return $this->modules()->count();
  }

  public function entities($type = null) {

    if(is_null($type)) {
      $type = $this->variant();
    }

    $entities = new Brick('div');
    $entities->addClass('entities__container');

    $field      = $this;
    $numVisible = 0;
    $num        = 0;

    foreach($this->modules() as $page) {

      if($page->isVisible()) {
        $numVisible++;
      }

      $num++;

      $layout = Kirby\Entities\Entities::layout($type, compact('field', 'page', 'num', 'numVisible'));
      $entities->append($layout);

    }

    return $entities;

  }

  public function action($type, $data = array()) {
    $data = a::update($data, ['field' => $this, 'type' => $type]);
    return Kirby\Entities\Entities::action($type, $data);
  }

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

  public function preview($page) {

    if(!$preview = $this->options($page)->preview()) {
      return;
    }

    $module   = Kirby\Modules\Modules::instance()->get($page);
    $template = $module->path() . DS . $module->name() . '.preview.php';

    if(!is_file($template)) {
      return;
    }

    $position = $preview === true ? 'top' : $preview;

    $preview = new Brick('div');
    $preview->addClass('module__preview module__preview--' . $position);
    $preview->data('module', $module->name());
    $preview->html(tpl::load($template, array('page' => $this->orign(), 'module' => $page, 'moduleName' => $module->name())));

    return $preview;

  }

  public function counter($page) {

    if(!$page->isVisible() || !$this->options($page)->limit()) {
      return null;
    }

    $modules = $this->modules()->filterBy('template', $page->intendedTemplate());
    $index   = $modules->visible()->indexOf($page) + 1;
    $limit   = $this->options($page)->limit();

    $counter = new Brick('span');
    $counter->addClass('module__counter');
    $counter->html('( ' . $index . ' / ' . $limit . ' )');

    return $counter;

  }

  public function defaults() {

    // Return from cache if possible
    if($this->defaults) {
      return $this->defaults;
    }

    // Default values
    $defaults = array(
      'duplicate' => true,
      'preview' => true,
      'delete' => true,
      'toggle' => true,
      'limit' => false,
      'edit' => true,
    );

    if(!$this->options) {
      return $defaults;
    }

    // Filter options for default values
    $options = array_filter($this->options, function($value) {
      return !is_array($value);
    });

    return $this->defaults = a::update($defaults, $options);

  }

  public function options($template) {

    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    // Get module specific options
    $options = a::get($this->options, $template, array());

    if(!$options) {
      return new Obj($this->defaults());
    }

    return new Obj(a::update($this->defaults(), $options));

  }

  public function content() {

    $template = static::$entities->get('template', $this->template);
    $content  = new Brick('div');

    $content->addClass('enteties');
    $content->attr('data-field', 'entities');
    $content->attr('data-api', purl($this->model(), 'field/' . $this->name() . '/entities'));
    $content->append(tpl::load($template, array('field' => $this)));

    return $content;

  }

  public function modules() {

		// Return from cache if possible
		if($this->modules) {
      return $this->modules;
    }

    // Filter the modules by valid module
    $modules = $this->origin()->children()->filter(function($page) {
      // return $page;
      return Kirby\Modules\Modules::instance()->get($page);
    });

    // Sort modules
    if($modules->count() && $this->value()) {
      $i = 0;

      $order = a::merge(array_flip($this->value()), array_flip($modules->pluck('uid')));
      $order = array_map(function($value) use(&$i) {
        return $i++;
      }, $order);

      $modules = $modules->find(array_flip($order));
    }

    // Always return a collection
    if(is_a($modules, 'Page')) {
      $module  = $modules;
      $modules = new Children($this->origin());

      $modules->data[$module->id()] = $module;
    }

    return $this->modules = $modules;

  }

  public function origin() {

    // Return from cache if possible
    if($this->origin) {
      return $this->origin;
    }

    // Get parent uid
    $parentUid = Kirby\Modules\Settings::parentUid();

    // Determine the modules root
    if(!$origin = $this->page()->find($parentUid)) {
      $origin = $this->page();
    }

    return $this->origin = $origin;

  }

  public function label() {

    // Load translation
    $this->translation();

    $label = new Brick('label');
    $label->addClass('label');
    $label->html($this->i18n($this->label));

    if($this->limit()) {
      $label->append(' <span class="modules__counter">( ' . $this->modules()->visible()->count() . ' / ' . $this->limit() . ' )</span>');
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

    return $this->element()
      ->append($this->content())
      ->append($this->help());

  }

}
