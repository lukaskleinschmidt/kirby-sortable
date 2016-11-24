<?php

return function($page, $model) {

  $form = new Kirby\Panel\Form(array(
    'page' => array(
      'label'    => 'fields.modules.delete.headline',
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
