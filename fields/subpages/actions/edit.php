<?php $disabled = $options->edit() === false || $module->ui()->read() === false; ?>
<a class="module__action<?php if($disabled) echo ' is-disabled'; ?>" href="<?php echo $module->url('edit'); ?>" title="<?php echo l('fields.modules.module.edit'); ?>">
  <?php i('pencil'); ?>
</a>
