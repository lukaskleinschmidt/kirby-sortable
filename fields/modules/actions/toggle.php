<?php $disabled = $options->toggle() === false || $module->blueprint()->options()->status() === false || $module->ui()->visibility() === false; ?>
<?php if($module->isVisible()): ?>
  <a class="module__action<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" data-action title="<?php echo l('fields.modules.module.hide'); ?>">
    <?php i('toggle-on'); ?>
  </a>
<?php else: ?>
  <a class="module__action<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" data-action title="<?php echo l('fields.modules.module.show'); ?>">
    <?php i('toggle-off'); ?>
  </a>
<?php endif; ?>
