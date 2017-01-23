<?php

class ToggleAction extends BaseAction {

  public $status;
  public $icon = array(
    'hide' => 'toggle-on',
    'show' => 'toggle-off',
  );
  public $title = array(
    'hide' => array(
      'en' => 'Hide',
      'de' => 'Verstecken',
    ),
    'show' => array(
      'en' => 'Show',
      'de' => 'Anzeigen',
    ),
  );

  public function status() {
    if($this->status) return $this->status;
    return $this->status = $this->page()->isVisible() ? 'hide' : 'show';
  }

  public function params() {

    $params = array(
      $this->status(),
      $this->page()->uid(),
    );

    if($this->status() == 'show') {
      return a::merge($params, ['to' => $this->layout()->numVisible() + 1]);
    }

    return $params;

  }

  public function title() {
    $title = a::get($this->title, $this->status());
    return $this->i18n($title);
  }

  public function icon($position = null) {
    if(empty($this->icon)) return null;
    $icon  = a::get($this->icon, $this->status());
    return icon($icon, $position);
  }

  public function routes() {
    return array(
      array(
        'pattern' => 'show/(:any)/(:any)',
        'method'  => 'POST|GET',
        'action'  => 'show',
        'filter'  => 'auth',
      ),
      array(
        'pattern' => 'hide/(:any)',
        'method'  => 'POST|GET',
        'action'  => 'hide',
        'filter'  => 'auth',
      ),
    );
  }

  public function content() {
    return tpl::load($this->root() . DS . 'template.php', ['action' => $this], true);
  }

  public function disabled() {
    return $this->disabled || $this->page()->ui()->visibility() === false;
  }

}
