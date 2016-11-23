<?php

return function($model, $field) {

  $cookie = cookie::get('kirby_field_modules_clipboard');
  $cookie = new Obj(json_decode($cookie));

  // dump($cookie);

  $options = array();

  $templates = $field->origin()->blueprint()->pages()->template();

  $modules = page($cookie->origin())->children()->find($cookie->modules());

  foreach($modules as $module) {
    $options[$module->uri()] = $module->title();
  }

  $form = new Kirby\Panel\Form(array(
    'modules' => array(
      'label'    => 'fields.modules.add.template.label',
      'type'     => 'checkboxes',
      'columns'  => 1,
      'options'  => $options,
      'value'  => true,
      // 'default'  => key($options),
      // 'required' => true,
      // 'readonly' => count($options) == 1 ? true : false,
      // 'icon'     => count($options) == 1 ? $templates->first()->icon() : 'chevron-down',
    ),
  ));

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));

  return $form;

};
