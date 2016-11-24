<div id="<?php echo $field->id(); ?>" class="modules"
  data-field="modules"
  data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>"
  data-copy="<?php echo $field->copy() ? 'true' : 'false'; ?>">

  <?php $i = 0; $n = 0; foreach($field->modules() as $module): $i++; if($module->isVisible()) $n++; $options = $field->options($module); ?>
  <div class="module"
    data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>"
    data-uid="<?php echo $module->uid(); ?>">

    <?php // echo $field->layout($options->layout(), compact('field', 'module', 'options', 'i', 'n')); ?>
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

<nav class="modules__navigation">
  <?php if($field->copy()): ?>
    <button type="button" data-action="<?php echo $field->url('copy'); ?>"><?php i('copy', 'left'); ?> Copy</button>
    <button type="button" data-action="<?php echo $field->url('paste'); ?>"><?php i('paste', 'left'); ?> Paste</button>
  <?php endif; ?>
  <a href="<?php echo $field->url('add'); ?>" data-modal><?php i('plus-circle', 'left'); ?> Add</a>
</nav>
