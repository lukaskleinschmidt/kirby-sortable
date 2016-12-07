<?php $disabled = $options->delete() === false || $module->blueprint()->options()->delete() === false || $module->ui()->delete() === false; ?>
<a class="module__action<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal title="<?php echo l('fields.modules.module.delete'); ?>">
  <?php i('trash-o'); ?>
</a>
