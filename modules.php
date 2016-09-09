<?php

class ModulesField extends BaseField {
  // Caches
  protected $defaults = array();
  protected $origin = null;
  protected $pages = null;
  protected $limit = false;

  public $readonly = false;
  public $options = array();
  public $style = 'items';

  static public $assets = array(
    'js' => array(
      'modules.js',
    ),
    'css' => array(
      'modules.css',
    ),
  );

  public function __construct() {
    // Path to language files
    $path = __DIR__ . DS . 'languages' . DS;

    // Intendet language file
    $language = $path . panel()->translation()->code() . '.php';

    // Try to load intended language file and fallback to default language
    if(is_file($language)) {
      require_once($language);
    } else {
      require_once($path . 'en.php');
    }

    // Define autoloader
    load(array(
      'kirby\\field\\modules\\module'     => __DIR__ . DS . 'module.php',
    ));
  }

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
        'action'  => 'delete',
      ),
      array(
        'pattern' => 'duplicate',
        'method'  => 'get|post',
        'action'  => 'duplicate',
      ),
    );
  }

  public function defaults() {
    // Return from cache if possible
    if($this->defaults) return $this->defaults;

    // Filter options for default values
    $defaults = array_filter($this->options, function($value) {
      return !is_array($value);
    });

    return $this->defaults = $defaults;
  }

  public function options($template) {
    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    // Get module specific options
    $options = a::get($this->options, $template, array());

    return a::update($this->defaults(), $options);
  }

  public function module($page) {
    $prefix = \Kirby\Modules\Modules::templatePrefix();
    $prefixLength = str::length($prefix);
    $name = str::substr($page->intendedTemplate(), $prefixLength);

    // Get the path of the module
    $path = kirby()->get('module', $name);

    return new Kirby\Field\Modules\Module($this, $page, $name, $path);
  }

  public function modules($pages) {
    foreach ($pages as $page) {
      $module = $this->module($page);
      $data = compact('page', 'module');
      $data['field'] = $this;
      echo tpl::load(__DIR__ . DS . 'etc' .  DS . 'template-module.php', $data);
    }
  }

  public function entries($visible = true) {
    $pages = $this->pages();
    $pages = $visible ? $pages->visible() : $pages->invisible();

    $status = $visible ? 'visible' : 'invisible';
    $limit = $visible ? $this->limit() : null;
    $count = $pages->count();

    $data = compact('pages', 'status', 'limit', 'count');
    $data['field'] = $this;

    echo tpl::load(__DIR__ . DS . 'etc' .  DS . 'template-modules.php', $data);
  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'etc' . DS . 'template.php', array('field' => $this));
  }

  public function pages() {
    // Return from cache if possible
    if($this->pages) return $this->pages;

    $pages = $this->origin()->children()->filter(function($page) {
      try {
        $module = Kirby\Modules\Modules::module($page);
        return $module && $module->validate();
      } catch(Error $e) {
        return false;
      }
    });

    return $this->pages = $pages;
  }

  public function origin() {
    // Return from cache if possible
    if($this->origin) return $this->origin;

    // Determine where the modules live
    if(!$origin = $this->page()->find(Kirby\Modules\Modules::parentUid())) $origin = $this->page();

    return $this->origin = $origin;
  }

  public function data() {
    $templates = $this->origin()->blueprint()->pages()->template();
    $modules = array();

    foreach($templates as $template) {
      $modules[] = array(
        'options' => $this->options($template->name()),
        'template' => $template->name(),
      );
    }

    $data = array(
      'url' => $this->origin()->url('subpages'),
      'limit' => $this->limit(),
      'modules' => $modules,
    );

    return json_encode($data);
  }

  public function limit() {
    // Return from cache if possible
    if($this->limit !== false) return $this->limit;

    return $this->limit = $this->origin()->blueprint()->pages()->max();
  }

  public function counter($count, $limit = null) {
    $values = array($count);

    if($limit) $values[] = $limit;

    $counter = new Brick('span');
    $counter->addClass('counter');
    $counter->html('( ' . implode(' / ', $values) . ' )');

    return $counter;
  }

  public function label() {
    // Make sure there's at least an empty label
    if(!$this->label) $this->label = '&nbsp;';

    $label = new Brick('label');
    $label->addClass('label');
    $label->html($this->label);

    if(!$this->readonly) {
      $add = new Brick('a');
      $add->addClass('modules-add-button label-option');
      $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.modules.add'));
      $add->data('modal', true);
      $add->attr('href', $this->url('add'));

      // Add to the label
      $label->append($add);
    }

    return $label;
  }

  public function url($action) {
    switch($action) {
      case 'add':
        return purl($this->model(), 'field/' . $this->name() . '/modules/' . $action);
        break;
    }
  }
}
