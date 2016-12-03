<?php

return function($page, $modules, $model) {

  $options = [];
  $fields  = [];

  if($modules->count()) {

    foreach($modules as $module) {
      $options[$module->uri()] = array(
        'label'    => $module->title(),
        'checked'  => true,
        'readonly' => false,
      );
    }

    $fields['uri'] = array(
      'label'    => 'fields.modules.copy.uri.label',
      'type'     => 'options',
      'columns'  => 1,
      'required' => true,
      'options'  => $options
    );

  } else {

    $fields['info'] = array(
      'label' =>  l('fields.modules.copy.info.label'),
      'type'  => 'info',
      'text'  => l('fields.modules.copy.info.text')
    );

  }

  $form = new Kirby\Panel\Form($fields);

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));

  if(!$modules->count()) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
