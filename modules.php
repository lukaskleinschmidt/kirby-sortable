<?php

class ModulesField extends BaseField {
  protected $modules;
  protected $modulesRoot;
  protected $modulesOptions;

  public $tyle     = 'items';
  public $readonly = false;
  public $redirect = true;
  public $options  = [];

  static public $defaults = array(
    'preview' => true,
    'delete' => true,
    'edit' => true,
    'max' => 0,
  );

  static public $assets = array(
    'js' => array(
      'dist/modules.js',
    ),
    'css' => array(
      'modules.css',
    ),
  );

  public function __construct() {
    // Path to language files
    $path = __DIR__ . DS . 'languages' . DS;

    // Intended language file
    $language = $path . panel()->translation()->code() . '.php';

    // Try to load intended language file and fallback to default language
    if(is_file($language)) {
      require_once($language);
    } else {
      require_once($path . 'en.php');
    }

    // Define autoloader
    load(array(
      'kirby\\field\\modules\\module' => __DIR__ . DS . 'lib' . DS . 'module.php'
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
    );
  }

  public function modules() {
    // Return from cache if possible
    if($this->modules) return $this->modules;
        
    // Filter the modules by valid module
    $modules = $this->modulesRoot()->children()->filter(function($page) {
      try {
        $module = new Kirby\Field\Modules\Module($page, 'test');
        return $module->validate();
      } catch(Error $e) {
        return false;
      }
    });
    
    return $this->modules = $modules;
  }

  public function modulesRoot() {
    // Return from cache if possible
    if($this->modulesRoot) return $this->modulesRoot;

    // Determine where the modules live
    if(!$modulesRoot = $this->page->find(Kirby\Modules\Modules::parentUid())) $modulesRoot = $this->page;

    return $this->modulesRoot = $modulesRoot;
  }

  public function content() {

    // dump($this->modulesRoot->blueprint()->pages()->max());

    // dump($this->options());

    return tpl::load(__DIR__ . DS . 'templates' . DS . 'field.php', array('field' => $this));
  }

  public function option($page, $key) {
    // Get template specific options
    $options = a::get($this->options, $page->intendedTemplate(), array());

    // Get specific option by key
    $option = a::get($options, $key);

    // Return default value if option is not set
    return is_null($option) ? a::get(static::$defaults, $key) : $option;
  }

  public function preview($page) {
    $module = new Kirby\Field\Modules\Module($page, 'test');

    $name = $module->name();

    var_dump($module->max());
    $template = Kirby\Modules\Modules::directory() . DS . $name . DS . $name . '.preview.php';

    if(!is_file($template)) return null;

    $preview = new Brick('div');
    $preview->addClass('modules-entry-preview');
    $preview->data('module', $name);
    $preview->html(tpl::load($template, array('module' => $page)));

    return $preview;
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

  public function url($action, $query = array('template' => array('module.gallery', 'module.text'))) {
    if($action == 'delete' || !$this->redirect()) {
      $redirect = $this->page()->uri('edit');
      $query['_redirect'] = $redirect != $this->modulesRoot()->uri('edit') ? $redirect : null;
    }

    $query = url::queryToString($query);
    $query = $query ? '?' . $query : '';

    return purl($this->model(), 'field/' . $this->name() . '/modules/' . $action . $query);
  }
}