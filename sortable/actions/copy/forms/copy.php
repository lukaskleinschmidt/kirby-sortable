<?php

return function($page, $entries, $model, $field) {

  if($entries->count()) {

    $options = [];

    foreach($entries as $entry) {
      $options[$entry->uri()] = array(
        'label'    => $entry->title(),
        'checked'  => true,
        'readonly' => false,
      );
    }

    $form = new Kirby\Panel\Form(array(
      'uri' => array(
        'label'    => $field->l('field.sortable.copy.uri.label'),
        'type'     => 'options',
        'columns'  => 1,
        'required' => true,
        'options'  => $options,
      )
    ));

  } else {

    $form = new Kirby\Panel\Form(array(
      'info' => array(
        'label' =>  $field->l('field.sortable.copy.info.label'),
        'type'  => 'info',
        'text'  => $field->l('field.sortable.copy.info.text')
      )
    ));

  }

  $form->cancel($model);
  $form->buttons->submit->val($field->l('field.sortable.copy'));

  if(!$entries->count()) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
