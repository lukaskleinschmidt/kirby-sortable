<?php

return function($model, $field) {

  $form = new Kirby\Panel\Form(array(
    'page' => array(
      'label'    => $field->l('field.sortable.demo.label'),
      'type'     => 'info',
      'text'     => $field->l('field.sortable.demo.text'),
    )
  ));

  $form->cancel($model);
  $form->buttons->submit->val($field->l('field.sortable.demo.submit'));

  return $form;

};
