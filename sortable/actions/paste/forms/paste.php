<?php

return function($page, $entries, $model, $field) {

  if($entries->count()) {

    $templates = $page->blueprint()->pages()->template();
    $options   = [];
    $help      = false;

    foreach($entries as $entry) {
      $template = $entry->intendedTemplate();
      $value    = $entry->uri();

      $options[$value] = array(
        // 'label'    => icon($templates->findBy('name', $template)->icon(), 'left') . ' ' . $entry->title(),
        'label'    => $entry->title(),
        'checked'  => true,
        'readonly' => false,
      );

      if(v::notIn($template, $templates->pluck('name'))) {
        $options[$value]['checked'] = false;
        $options[$value]['readonly'] = true;

        $help = true;
      }
    }

    $form = new Kirby\Panel\Form(array(
      'uri' => array(
        'label'    => $field->l('field.sortable.paste.uri.label'),
        'type'     => 'options',
        'columns'  => 1,
        'required' => true,
        'options'  => $options,
        'help'     => $help ? $field->l('field.sortable.paste.uri.help') : '',
      )
    ));

  } else {

    $form = new Kirby\Panel\Form(array(
      'info' => array(
        'label' =>  $field->l('field.sortable.paste.info.label'),
        'type'  => 'info',
        'text'  => $field->l('field.sortable.paste.info.text')
      )
    ));

  }

  $form->cancel($model);
  $form->buttons->submit->val($field->l('field.sortable.paste'));

  if(!$entries->count()) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
