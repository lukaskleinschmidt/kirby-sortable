<a class="module__action<?php if(!$options->duplicate()) echo ' is-disabled'; ?>" href="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 1)); ?>" data-action title="<?php echo l('fields.modules.module.duplicate'); ?>">
  <?php i('clone'); ?>
</a>
