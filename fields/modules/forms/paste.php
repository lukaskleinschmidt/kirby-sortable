<?php

return function($page, $modules, $model) {

  if($modules->count()) {

    $templates = $page->blueprint()->pages()->template();
    $options   = [];
    $help      = false;

    foreach($modules as $module) {
      $template = $module->intendedTemplate();
      $value    = $module->uri();

      $options[$value] = array(
        // 'label'    => icon($templates->findBy('name', $template)->icon(), 'left') . ' ' . $module->title(),
        'label'    => $module->title(),
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
        'label'    => 'fields.modules.paste.uri.label',
        'type'     => 'options',
        'columns'  => 1,
        'required' => true,
        'options'  => $options,
        'help'     => $help ? l('fields.modules.paste.uri.help') : '',
      )
    ));

  } else {

    $form = new Kirby\Panel\Form(array(
      'info' => array(
        'label' =>  l('fields.modules.paste.info.label'),
        'type'  => 'info',
        'text'  => l('fields.modules.paste.info.text')
      )
    ));

  }

  $form->cancel($model);
  $form->buttons->submit->val(l('fields.modules.paste'));

  if(!$modules->count()) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
