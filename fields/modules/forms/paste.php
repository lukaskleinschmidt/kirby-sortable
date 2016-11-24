<?php

return function($page, $model) {

  $cookie = cookie::get('kirby_field_modules');
  $cookie = new Obj(json_decode($cookie));

  $templates = $page->blueprint()->pages()->template();
  $modules   = page($cookie->origin())->children()->find($cookie->modules());

  if(is_a($modules, 'Page')) {
    $module = $modules;
    $modules = new Children(page($cookie->origin()));
    $modules->data[$module->id()] = $module;
  }

  $options = [];

  foreach($modules as $module) {
    $template = $module->intendedTemplate();
    $value    = $module->uri();

    $options[$value] = array(
      // 'label'    => icon($templates->findBy('name', $template)->icon(), 'left') . ' ' . $module->title(),
      'label'    => $module->title(),
      'checked'  => true,
      'readonly' => false,
    );

    if(v::notIn($template, $templates->pluck('name'))) {
      $options[$value]['checked'] = false;
      $options[$value]['readonly'] = true;
    }
  }

  $form = new Kirby\Panel\Form(array(
    'modules' => array(
      'label'   => 'fields.modules.paste.headline',
      'type'    => 'options',
      'columns' => 1,
      'options' => $options,
      'help'    => 'One or more modules are not available in this page',
    ),
    'to' => array(
      'label'    => 'Position',
      'type'     => 'select',
      'required' => true,
      'default'  => 1,
      'options'  => array(
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
      ),
    ),

  ));

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));
  // unset($form->buttons->submit);

  return $form;

};
