<?php

use Kirby\Modules;

return function($page, $cancel) {

  $options = array();

  foreach($page->blueprint()->pages()->template() as $template) {
    $options[$template->name()] = $template->title();
  }

  $uid = sprintf('%u', crc32(time()));

  $form = new Kirby\Panel\Form(array(
    'title' => array(
      'label'        => 'pages.add.title.label',
      'type'         => 'title',
      'placeholder'  => 'pages.add.title.placeholder',
      'autocomplete' => false,
      'autofocus'    => true,
      'required'     => true
    ),
    'uid' => array(
      'label'        => 'pages.add.url.label',
      'type'         => 'text',
      'placeholder'  => $uid,
      'autocomplete' => false,
      'required'     => true,
      'icon'         => 'chain',
    ),
    'template' => array(
      'label'    => 'pages.add.template.label',
      'type'     => 'select',
      'options'  => $options,
      'default'  => key($options),
      'required' => true,
      'readonly' => count($options) == 1 ? true : false,
      'icon'     => count($options) == 1 ? $page->blueprint()->pages()->template()->first()->icon() : 'chevron-down',
    ),
  ));

  $form->action($page->url('add'));
  $form->cancel($cancel);

  $form->buttons->submit->val(l('add'));

  return $form;
};