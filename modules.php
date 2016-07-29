<?php

use Kirby\Modules;

class ModulesField extends BaseField {
  protected $modules;
  protected $modulesRoot;

  public $style    = 'table'; // preview
  public $readonly = false;
  public $redirect = true;

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
    $file = $path . panel()->translation()->code() . '.php';

    // Try to load intended language file and fallback to default language
    if(is_file($file)) {
      require_once($file);
    } else {
      require_once($path . 'en.php');
    }
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
        $module = new Modules\Module($page);
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
    if(!$modulesRoot = $this->page->find(Modules\Modules::parentUid())) $modulesRoot = $this->page;

    return $this->modulesRoot = $modulesRoot;
  }

  public function entries($file, $data = array()) {
    return tpl::load(__DIR__ . DS . 'styles' . DS . $file . '.php', $data);;
  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

  public function entry($module) {
    if ($this->style == 'preview') {
      $intendedTemplate = $module->intendedTemplate();
      $templatePrefix   = Modules\Modules::templatePrefix();

      // Get the module name from the template
      $name = str::substr($intendedTemplate, str::length($templatePrefix));
      $path = Modules\Modules::directory() . DS . $name . DS . $name . '.preview.php';

      $preview = new Brick('div');
      $preview->addClass('modules-entry-preview');
      $preview->attr('template', $name);
      $preview->html(tpl::load($path, compact('module')));

      // Return preview 
      return $preview;
    }

    $title = new Brick('span');
    $title->addClass('modules-entry-title');
    $title->html($module->icon() . $module->title());

    return $title;
  }

  public function label() {
    return null;
  }

  public function headline() {
    if(!$this->readonly) {
      $add = new Brick('a');
      $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.modules.add'));
      $add->addClass('modules-add-button label-option');
      $add->data('modal', true);
      $add->attr('href', $this->url('add'));
    } else {
      $add = null;
    }

    // make sure there's at least an empty label
    if(!$this->label) {
      $this->label = '&nbsp;';
    }
 
    $label = parent::label();
    $label->addClass('modules-label');
    $label->append($add);

    return $label;
  }

  public function url($action, $query = array()) {
    if($action == 'sort') return $this->modulesRoot()->url('subpages');

    if($action == 'delete' || !$this->redirect()) {
      $redirect = $this->page()->uri('edit');
      $query['_redirect'] = $redirect != $this->modulesRoot()->uri('edit') ? $redirect : null;
    }

    $query = url::queryToString($query);
    $query = $query ? '?' . $query : '';

    return purl($this->model(), 'field/' . $this->name() . '/modules/' . $action . $query);
  }
}
?>