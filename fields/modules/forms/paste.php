<?php

return function($page, $modules, $model) {

  $templates = $page->blueprint()->pages()->template();
  $options   = [];
  $fields    = [];
  $help      = false;

  if($modules) {

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

    $fields['modules'] = array(
      'label'    => 'fields.modules.paste.headline',
      'type'     => 'options',
      'columns'  => 1,
      'required' => true,
      'options'  => $options,
      'help'     => $help ? 'One or more modules are not available in this page' : '',
    );

  } else {

    $fields['info'] = array(
      'label' => 'Clipboard is empty',
      'type'  => 'info',
      'text'  => 'There are no modules stored in the clipboard at the moment. For further information please refer to the documentaion on (link:https://github.com/lukaskleinschmidt/kirby-field-modules text: github target: _blank).'
    );

  }

  $form = new Kirby\Panel\Form($fields);

  $form->cancel($model);
  $form->buttons->submit->val(l('add'));

  if(!$modules) {
    $form->buttons->submit = $form->buttons->cancel;
    $form->style('centered');
  }

  return $form;

};
