<a class="module__action<?php if(!$options->delete() || !$module->blueprint()->options()->delete()) echo ' is-disabled'; ?>" href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal title="<?php echo l('fields.modules.module.delete'); ?>">
  <?php i('trash-o'); ?>
</a>
