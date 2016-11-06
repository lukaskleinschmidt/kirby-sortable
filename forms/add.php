<?php

return function($model, $field) {

  $options = array();

  foreach($field->origin()->blueprint()->pages()->template() as $template) {
    $options[$template->name()] = icon($template->icon(), 'left') . ' ' . $template->title();
  }

  $form = new Kirby\Panel\Form(array(
    'module' => array(
      'label'    => 'fields.modules.add.template.label',
      'type'     => 'select',
      'columns'  => 1,
      'options'  => $options,
      'default'  => key($options),
      'required' => true,
      'readonly' => count($options) == 1 ? true : false,
      'icon'     => count($options) == 1 ? $templates->first()->icon() : 'chevron-down',
    ),
  ));

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));

  return $form;
};
