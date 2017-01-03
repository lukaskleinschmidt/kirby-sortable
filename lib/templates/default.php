<div class="module"
  data-visible="<?php echo $page->isVisible() ? 'true' : 'false'; ?>"
  data-uid="<?php echo $page->uid(); ?>">

  <?php
    $module   = Kirby\Modules\Modules::instance()->get($page);
    $template = $module->path() . DS . $module->name() . '.preview.php';

    if(is_file($template)) {
      $preview = new Brick('div');
      $preview->addClass('module__preview module__preview--top');
      $preview->data('module', $module->name());
      $preview->html(tpl::load($template, array('page' => $this->orign(), 'module' => $page, 'moduleName' => $module->name())));

      echo $preview;
    }

  ?>

  <nav class="module__navigation">
    <div class="module__title">
      <div class="module__icon">
        <?php echo $module->icon('left'); ?>
      </div>
      <?php echo $module->title(); ?>
      <?php echo $field->counter($module); ?>
    </div>

    <?php $page->actions(['edit', 'duplicate', 'delete', 'toggle']); ?>

  </nav>

  <?php echo $field->input($module->uid()); ?>

</div>
