<div id="<?php echo $field->id(); ?>" class="modules"
  data-field="modules"
  data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>"
  data-copy="<?php echo $field->copy() ? 'true' : 'false'; ?>"
  data-paste="<?php echo $field->paste() && $field->origin()->ui()->create() ? 'true' : 'false'; ?>">

  <?php if($field->modules()->count()): ?>
    <div class="modules__container">

      <?php //$field->entities(); ?>
      <?php /*
      <?php $i = 0; $n = 0; foreach($field->modules() as $module): $i++; if($module->isVisible()) $n++; $options = $field->options($module); ?>


      <?php echo $field->entity($field, $module, $i, $n); ?>

      <div class="module"
        data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>"
        data-uid="<?php echo $module->uid(); ?>">

        <?php if($options->preview() === true || $options->preview() === 'top') echo $field->preview($module); ?>

        <nav class="module__navigation">
          <div class="module__title">
            <div class="module__icon">
              <?php echo $module->icon('left'); ?>
            </div>
            <?php echo $module->title(); ?>
            <?php echo $field->counter($module); ?>
          </div>
          <?php

            // echo $field->actions(compact('field', 'module', 'options', 'i', 'n'));

            // $registry = Kirby\Elements\Registry::instance();
            foreach($field->actions as $action) {
              echo $field->action($action, ['num' => $i, 'numVisible' => $n, 'field' => $field, 'page' => $module]);
              // $field->action($action, compact('field', 'module', 'options', 'i', 'n'), false);
              // tpl::load(__DIR__ . DS . 'actions' . DS . $action . '.php', compact('field', 'module', 'options', 'i', 'n'), false);
            };
          ?>
        </nav>

        <?php if($options->preview() === 'bottom') echo $field->preview($module); ?>
        <?php echo $field->input($module->uid()); ?>

      </div>
      <?php endforeach; ?>
      */ ?>
    </div>
  <?php else: ?>

    <div class="modules__empty">

      <?php //echo l('fields.modules.empty'); ?>
      <?php //$field->action('add', ['label' => l('fields.modules.empty.add')]); ?>
      <?php //echo l('fields.modules.empty.or'); ?>
      <?php //$field->action('paste', ['label' => l('fields.modules.empty.paste')]); ?>

      <?php /*if($field->add()): ?>
        <a href="<?php echo $field->url('add'); ?>" data-modal><?php echo l('fields.modules.empty.add'); ?></a>
      <?php endif;*/ ?>
      <?php /*if($field->add() && $field->paste()): ?>
        <?php echo l('fields.modules.empty.or'); ?>
        <a href="<?php echo $field->url('paste'); ?>" data-modal data-shortcut="meta+v"><?php echo l('fields.modules.empty.paste'); ?></a>
      <?php endif; */?>
    </div>

  <?php endif; ?>

  <nav class="modules__navigation">
    <?php //$field->action('copy'); ?>
    <?php //$field->action('paste'); ?>
    <?php //$field->action('add'); ?>

    <?php /*
    <?php $disabled = $field->copy() === false; ?>
    <a class="modules__action modules__action--copy<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('copy'); ?>" data-modal><?php i('copy', 'left'); ?><?php echo l('fields.modules.copy'); ?></a>
    <?php $disabled = $field->add() === false || $field->paste() === false || $field->origin()->ui()->create() === false; ?>
    <a class="modules__action modules__action--paste<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('paste'); ?>" data-modal><?php i('paste', 'left'); ?><?php echo l('fields.modules.paste'); ?></a>
    <?php $disabled = $field->add() === false || $field->origin()->ui()->create() === false; ?>
    <a class="modules__action modules__action--add<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('add'); ?>" data-modal><?php i('plus-circle', 'left'); ?><?php echo l('fields.modules.add'); ?></a>
    */ ?>
  </nav>
</div>
