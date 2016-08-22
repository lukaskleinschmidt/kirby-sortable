<?php

return function($page, $cancel) {
  $templates = $page->blueprint()->pages()->template();
  $options   = array();

  var_dump($cancel->toArray());

  foreach($templates as $template) {
    $options[$template->name()] = $template->title();
  }

  $uid = substr(sprintf('%u', crc32(time())), 0, 8);

  $form = new Kirby\Panel\Form(array(
    'title' => array(
      'label'        => 'fields.modules.add.title.label',
      'type'         => 'hidden', // title
      'default'      => $templates->first()->title(),
      'placeholder'  => 'pages.add.title.placeholder',
      'autocomplete' => false,
      'autofocus'    => true,
      'required'     => true
    ),
    'uid' => array(
      'label'        => 'fields.modules.add.url.label',
      'type'         => 'hidden', // text
      'default'      => $uid,
      'autocomplete' => false,
      'required'     => true,
      'icon'         => 'chain',
    ),
    'template' => array(
      'label'    => 'fields.modules.add.template.label',
      'type'     => 'select',
      'options'  => $options,
      'default'  => key($options),
      'required' => true,
      'readonly' => count($options) == 1 ? true : false,
      'icon'     => count($options) == 1 ? $templates->first()->icon() : 'chevron-down',
    ),
  ));

  $form->action($page->url('add'));
  $form->cancel($cancel);

  $form->buttons->submit->val(l('add'));

  return $form;
};