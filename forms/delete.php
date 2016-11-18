<?php

return function($model) {

  $form = new Kirby\Panel\Form(array(
    'uid' => array(
      'label'        => 'uid',
      'type'         => 'text',
      'autocomplete' => false,
      'autofocus'    => false,
      'required'     => true
    )
  ));

  $form->cancel($model);
  $form->style('delete');
  $form->buttons->submit->val(l('delete'));

  return $form;
};
