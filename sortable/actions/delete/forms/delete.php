<?php

return function($page, $model, $field) {

  $form = new Kirby\Panel\Form(array(
    'page' => array(
      'label'    => $field->l('field.sortable.delete.page.label'),
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
