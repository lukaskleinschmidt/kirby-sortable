<div id="<?php echo $field->id(); ?>" class="modules"
  data-field="modules"
  data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>"
  data-copy="<?php echo $field->copy() ? 'true' : 'false'; ?>"
  data-paste="<?php echo $field->paste() ? 'true' : 'false'; ?>">

  <?php if($field->modules()->count()): ?>
    <div class="modules__container">
      <?php $i = 0; $n = 0; foreach($field->modules() as $module): $i++; if($module->isVisible()) $n++; $options = $field->options($module); ?>
      <div class="module"
        data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>"
        data-uid="<?php echo $module->uid(); ?>">

        <?php if($options->preview() === true || $options->preview() === 'top') echo $field->preview($module); ?>

        <nav class="module__navigation">
          <div class="module__title">
            <div class="module__icon">
              <?php echo $module->icon('left'); ?>
              <!-- <a href="#<?php echo $field->id(); ?>" data-context="<?php echo $field->url('options', array('uid' => $module->uid())); ?>"><?php i('ellipsis-h'); ?></a> -->
            </div>
            <?php echo $module->title(); ?>
            <?php echo $field->counter($module); ?>
          </div>
          <?php foreach($field->actions() as $action) { tpl::load(__DIR__ . DS . 'actions' . DS . $action . '.php', compact('field', 'module', 'options', 'i', 'n'), false); }; ?>
        </nav>

        <?php if($options->preview() === 'bottom') echo $field->preview($module); ?>
        <?php echo $field->input($module->uid()); ?>

      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="modules__empty">
      <?php echo l('fields.modules.empty'); ?>
      <?php if($field->add()): ?>
        <a href="<?php echo $field->url('add'); ?>" data-modal><?php echo l('fields.modules.empty.add'); ?></a>
      <?php endif; ?>
      <?php if($field->add() && $field->paste()): ?>
        <?php echo l('fields.modules.empty.or'); ?> <a href="<?php echo $field->url('paste'); ?>" data-modal data-shortcut="meta+v"><?php echo l('fields.modules.empty.paste'); ?></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <nav class="modules__navigation">
    <?php if($field->copy()): ?>
      <a class="modules__action modules__action--copy" href="<?php echo $field->url('copy'); ?>" data-modal><?php i('copy', 'left'); ?><?php echo l('fields.modules.copy'); ?></a>
    <?php endif; ?>
    <?php if($field->paste()): ?>
      <a class="modules__action modules__action--paste" href="<?php echo $field->url('paste'); ?>" data-modal><?php i('paste', 'left'); ?><?php echo l('fields.modules.paste'); ?></a>
    <?php endif; ?>
    <?php if($field->add()): ?>
      <a class="modules__action modules__action--add" href="<?php echo $field->url('add'); ?>" data-modal><?php i('plus-circle', 'left'); ?><?php echo l('fields.modules.add'); ?></a>
    <?php endif; ?>
  </nav>
</div>
