<?php

class ModulesField extends InputField {

  protected $defaults;
  protected $modules;
  protected $origin;

  public $options = array();
  public $limit = false;

  static public $assets = array(
    'js' => array(
      'modules.js',
    ),
    'css' => array(
      'modules.css',
    ),
  );

  public function routes() {
    return array(
      array(
        'pattern' => 'add',
        'method'  => 'get|post',
        'action'  => 'add'
      ),
      array(
        'pattern' => 'delete',
        'method'  => 'get|post',
        'action'  => 'delete'
      ),
      array(
        'pattern' => 'duplicate',
        'method'  => 'get|post',
        'action'  => 'duplicate'
      ),
      array(
        'pattern' => 'show',
        'method'  => 'get|post',
        'action'  => 'show'
      ),
      array(
        'pattern' => 'hide',
        'method'  => 'get|post',
        'action'  => 'hide'
      ),
      array(
        'pattern' => 'sort',
        'method'  => 'get|post',
        'action'  => 'sort',
      ),
      array(
        'pattern' => 'options',
        'method'  => 'get|post',
        'action'  => 'options',
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

    if(!$this->options($page)->preview()) {
      return;
    }

    $module = Kirby\Modules\Modules::module($page);
    $template = $module->path() . DS . $module->name() . '.preview.php';

    if(!is_file($template)) {
      return;
    }

    $preview = new Brick('div');
    $preview->addClass('module__preview');
    $preview->data('module', $module->name());
    $preview->html(tpl::load($template, array('module' => $page)));

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

  public function status($page) {

    // Check module specific limit
    $count = $this->modules()->filterBy('template', $page->intendedTemplate())->visible()->count();
    $limit = $this->options($page)->limit();

    if($limit && $count >= $limit) {
      return false;
    }

    // Check limit
    $count = $this->modules()->visible()->count();
    $limit = $this->limit();

    if($limit && $count >= $limit) {
      return false;
    }

    return true;

  }

  public function defaults() {

    // Return from cache if possible
    if($this->defaults) {
      return $this->defaults;
    }

    // Default values
    $defaults = array(
      // 'redirect' => false,
      'preview' => true,
      // 'delete' => true,
      'limit' => false,
      // 'edit' => true,
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
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

  public function modules() {

		// Return from cache if possible
		if($this->modules) {
      return $this->modules;
    }

    // Filter the modules by valid module
    $modules = $this->origin()->children()->filter(function($page) {
      try {
        $module = Kirby\Modules\Modules::module($page);
        return $module && $module->validate();
      } catch(Error $e) {
        return false;
      }
    });

    // Sort modules
    if($this->value()) {
      $i = 0;

      $order = a::merge(array_flip($this->value()), array_flip($modules->pluck('uid')));
      $order = array_map(function($value) use(&$i) {
        return $i++;
      }, $order);

      $modules = $modules->find(array_flip($order));
    }

    return $this->modules = $modules;

  }

  public function origin() {

    // Return from cache if possible
    if($this->origin) {
      return $this->origin;
    }

    // Get parent uid
    $parentUid = Kirby\Modules\Modules::parentUid();

    // Determine the modules root
    if(!$origin = $this->page()->find($parentUid)) {
      $origin = $this->page();
    }

    return $this->origin = $origin;

  }

  public function label() {

    $add = new Brick('a');
    $add->addClass('label-option');
    $add->html('<i class="icon icon-left fa fa-plus-circle"></i> Add');
    $add->data('modal', true);
    $add->attr('href', $this->url('add'));
    // $add->data('context', $this->url('add'));
    // $add->attr('href', '#' . $this->id());

    $label = new Brick('label');
    $label->addClass('label');
    $label->html($this->label);

    if($this->limit()) {
      $label->append(' <span class="modules__counter">( ' . $this->modules()->visible()->count() . ' / ' . $this->limit() . ' )</span>');
    }

    $label->append($add);

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

  public function url($action, $query = array()) {

    $query = url::queryToString($query);

    if($query) {
      $query = '?' . $query;
    }

    return purl($this->model(), implode('/', array('field', $this->name(), 'modules', $action)) . $query);

  }

}
