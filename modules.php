<?php

class ModulesField extends BaseField {
  // Caches
  protected $origin;
  protected $pages;

  // Inherits from subpages settings
  public $max = null;

  public $style = 'item';
  public $options = array();
  public $modules = array();
  public $readonly = false;
  public $redirect = false;

  static public $assets = array(
    'js' => array(
      'modules.js',
    ),
    'css' => array(
      'modules.css',
    ),
  );

  public function __construct() {
    require_once(__DIR__ . DS . 'bootstrap.php');
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

  public function options($template) {
    if(is_a($template, 'Page')) {
      $template = $template->intendedTemplate();
    }

    // Get module specific options
    $options = a::get($this->modules, $template, array());

    return a::update($this->options, $options);
  }

  public function module($page) {
    return new Kirby\Field\Modules\Module($this, $page);
  }

  public function modules($pages) {
    foreach ($pages as $page) {
      $module = $this->module($page);
      echo tpl::load(__DIR__ . DS . 'templates' .  DS . 'module.php', compact('page', 'module'));
    }
  }

  public function pages() {
    // Return from cache if possible
    if($this->pages) return $this->pages;

    $pages = $this->origin()->children()->filter(function($page) {
      try {
        $module = new Kirby\Modules\Module($page);
        return $module->validate();
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
      'max' => $this->max(),
      'url' => $this->origin()->url('subpages'),
      'modules' => $modules,
    );

    return json_encode($data);
  }

  public function max() {
    // Return from cache if possible
    if($this->max) return $this->max;

    return $this->max = $this->origin()->blueprint()->pages()->max();
  }

  public function counter($count, $max = false) {
    $values = array($count);

    $max = $max ? $this->max() : false;
    if($max) $values[] = $max;

    $counter = new Brick('span');
    $counter->addClass('counter');
    $counter->html('( ' . implode(' / ', $values) . ' )');

    return $counter;
  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'templates' . DS . 'field.php', array('field' => $this));
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
