<?php

return function($page, $modules, $model) {

  $templates = $page->blueprint()->pages()->template();

  $options = [];
  $fields  = [];

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

  if(!$modules->count()) {
    $fields['info'] = array(
      'label' => 'Nothing to see here',
      'type' => 'info',
      'text' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam.'
    );
  }

  if($modules->count()) {
    $fields['modules'] = array(
      'label'   => 'fields.modules.paste.headline',
      'type'    => 'options',
      'columns' => 1,
      'required' => true,
      'options' => $options,
      'help'    => 'One or more modules are not available in this page',
    );
  }

  if($modules->count()) {
    $count = range(1, $page->moduleList()->count() + 1);
    $fields['to'] = array(
      'label'    => 'Position',
      'type'     => 'select',
      'required' => true,
      'default'  => 1,
      'options'  => array_combine($count, $count),
    );
  }

  $form = new Kirby\Panel\Form($fields);

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));
  // unset($form->buttons->submit);

  return $form;

};
