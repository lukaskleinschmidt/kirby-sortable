<?php

return function($model) {

  $form = new Kirby\Panel\Form(array(
    'uid' => array(
      'label'        => 'uid',
      'type'         => 'text',
      'readonly'     => true,
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
