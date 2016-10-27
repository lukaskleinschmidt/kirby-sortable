<?php

return function($model) {

  $form = new Kirby\Panel\Form(array(
    'uid' => array(
      'label'        => 'uid',
      'type'         => 'hidden',
      'autocomplete' => false,
      'autofocus'    => true,
      'required'     => true
    ),
    'to' => array(
      'label'        => 'to',
      'type'         => 'hidden',
      'autocomplete' => false,
      'required'     => true,
      'required'     => true
    )
  ));

  $form->cancel($model);
  $form->buttons->submit->val(l('save'));

  return $form;
};
