<?php

return function($model) {

  $form = new Kirby\Panel\Form(array(
    'uid' => array(
      'label'        => 'uid',
      'type'         => 'text',
      'autocomplete' => false,
      'autofocus'    => true,
      'required'     => true
    )
  ));

  $form->cancel($model);
  $form->buttons->submit->val(l('save'));

  return $form;
};
