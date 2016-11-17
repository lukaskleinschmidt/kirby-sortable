<div id="<?php echo $field->id(); ?>"
  class="modules"
  data-field="modules"
  data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>"
  data-copy="<?php echo $field->copy() ? 'true' : 'false'; ?>">

  <?php $i = 0; $n = 0; foreach($field->modules() as $module): $i++; if($module->isVisible()) $n++; $options = $field->options($module); ?>
  <div class="module" data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>" data-uid="<?php echo $module->uid(); ?>">

    <?php if($options->preview() === true || $options->preview() === 'top') echo $field->preview($module); ?>

    <nav class="module__navigation">
      <div class="module__title">
        <div class="module__icon">
          <?php echo $module->icon('left'); ?>
          <!-- <a href="#<?php echo $field->id(); ?>" data-context="<?php echo $field->url('options', array('uid' => $module->uid())); ?>"><?php i('ellipsis-h'); ?></a> -->
        </div>

        <?php echo l('fields.modules.visible'); ?>
        <?php echo c::get('fields.modules.visible'); ?>
        <?php echo $module->title(); ?>
        <?php echo $field->counter($module); ?>
      </div>

      <a class="module__button" href="<?php echo $module->url('edit'); ?>" title="Edit">
        <?php i('pencil', $options->label() ? 'left' : ''); ?> <?php if($options->label()) echo 'Edit'; ?>
      </a>

      <a class="module__button" href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal title="Delete">
        <?php i('trash-o', $options->label() ? 'left' : ''); ?> <?php if($options->label()) echo 'Delete'; ?>
      </a>

      <?php if($options->duplicate()): ?>
      <a class="module__button" href="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 1)); ?>" data-action title="Duplicate">
        <?php i('clone'); ?>
      </a>
      <?php endif; ?>

      <?php if($module->isVisible()): ?>
        <a class="module__button" href="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" data-action title="Hide">
          <?php i('toggle-on'); ?>
        </a>
      <?php else: ?>
        <a class="module__button" href="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" data-action title="Show">
          <?php i('toggle-off'); ?>
        </a>
      <?php endif; ?>

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
