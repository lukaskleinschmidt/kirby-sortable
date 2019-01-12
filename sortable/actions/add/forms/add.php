<?php

return function($page, $model, $field) {

  $options = [];
  $templates = $page->blueprint()->pages()->template();

  if($prefix = $field->prefix()) {
    $templates = $templates->filter(function($template) use($prefix) {
      return str::startsWith($template, $prefix);
    });
  }

  foreach($templates as $template) {
    $options[$template->name()] = $template->title();
  }

  $form = new Kirby\Panel\Form(array(
    'template' => array(
      'label'    => $field->l('field.sortable.add.template.label'),
      'type'     => 'select',
      'options'  => $options,
      'default'  => key($options),
      'required' => true,
      'readonly' => count($options) == 1 ? true : false,
      'icon'     => count($options) == 1 ? $page->blueprint()->pages()->template()->first()->icon() : 'chevron-down',
    )
  ));

  $form->cancel($model);
  $form->buttons->submit->val($field->l('field.sortable.add'));

  return $form;

};
