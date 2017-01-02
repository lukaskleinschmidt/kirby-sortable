<?php $disabled = $options->duplicate() === false || $module->parent()->ui()->create() === false; ?>
<?php if($field->add()): ?>
  <a class="module__action<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 1)); ?>" data-action title="<?php echo l('fields.modules.module.duplicate'); ?>">
    <?php i('clone'); ?>
  </a>
<?php endif; ?>
