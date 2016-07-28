<?php

use Kirby\Modules;
use Kirby\Panel\Snippet;

class ModulesField extends BaseField {
  protected $modules;
  protected $modulesRoot;

  public $style    = 'module'; // module | preview
  public $readonly = false;

  static public $assets = array(
    'js' => array(
      'dist/modules.js',
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
        'pattern' => 'context',
        'method'  => 'get|post',
        'action'  => 'context'
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
    if(!$modulesRoot = $this->page->find(Modules\Modules::parentUid())) {
      $modulesRoot = $this->page;
    }

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
      $path = Modules\Modules::directory() . DS . $name . DS . $name . '.panel.php';

      // Return template 
      if($entry = tpl::load($path, compact('module'))) return $entry;
    }

    return '<span class="modules-entry-title">' . $module->icon() . $module->blueprint()->title() . '</span>';
  }

  public function label() {
    return null;
  }

  public function headline() {
    if(!$this->readonly) {
      $add = new Brick('a');
      $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.structure.add'));
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

    if($action == 'delete') {
      $redirect = $this->page()->uri('edit');
      $query['_redirect'] = $redirect != $this->modulesRoot()->uri('edit') ? $redirect : null;
    }

    $query = url::queryToString($query);
    $query = $query ? '?' . $query : '';

    return purl($this->model(), 'field/' . $this->name() . '/modules/' . $action . $query);
  }
}
?>