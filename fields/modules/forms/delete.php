<?php

return function($page, $model) {

  $form = new Kirby\Panel\Form(array(
    'page' => array(
      'label'    => 'fields.modules.delete.page.label',
      'type'     => 'text',
      'readonly' => true,
      'default'  => $page->title(),
      'help'     => $page->id(),
    )
  ));

  $form->cancel($model);
  $form->style('delete');

  return $form;

};
