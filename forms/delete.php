<?php 

return function($page, $cancel) {

  $form = new Kirby\Panel\Form(array(
    'page' => array(
      'label'    => 'fields.modules.delete.headline',
      'type'     => 'text',
      'readonly' => true,
      'icon'     => false,
      'default'  => $page->title(),
      'help'     => $page->id(),
    )
  ));

  $form->action($page->url('delete'));
  $form->style('delete');
  $form->cancel($cancel);

  return $form;
};