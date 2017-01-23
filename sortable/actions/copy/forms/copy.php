<?php

return function($page, $modules, $model) {

  if($modules->count()) {

    $options = [];

    foreach($modules as $module) {
      $options[$module->uri()] = array(
        'label'    => $module->title(),
        'checked'  => true,
        'readonly' => false,
      );
    }

    $form = new Kirby\Panel\Form(array(
      'uri' => array(
        'label'    => 'fields.modules.copy.uri.label',
        'type'     => 'options',
        'columns'  => 1,
        'required' => true,
        'options'  => $options,
      )
    ));

  } else {

    $form = new Kirby\Panel\Form(array(
      'info' => array(
        'label' =>  l('fields.modules.copy.info.label'),
        'type'  => 'info',
        'text'  => l('fields.modules.copy.info.text')
      )
    ));

  }

  $form->cancel($model);
  $form->buttons->submit->val(l('fields.modules.copy'));

  if(!$modules->count()) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
