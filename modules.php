<?php

class ModulesField extends InputListField {

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

  public function input() {

    $value = func_get_arg(0);
    $input = parent::input();
    $input->attr(array(
      'id'           => $value,
      'name'         => $this->name() . '[]',
      'type'         => 'text',
      'value'        => $value,
      'required'     => false,
      'autocomplete' => false,
    ));

    return $input;

  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

  public function modules() {

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
    if($this->origin) return $this->origin;

    // Get parent uid
    $parentUid = Kirby\Modules\Modules::parentUid();

    // Determine the modules root
    if(!$origin = $this->page()->find($parentUid)) {
      $origin = $this->page();
    }

    return $this->origin = $origin;

  }

  public function validate() {
    return true;
  }

  public function value() {

    $value = InputListField::value();

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

}
