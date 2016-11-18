<a class="module__button" href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal title="<?php echo l('fields.modules.module.delete'); ?>">
  <?php i('trash-o', $options->label() ? 'left' : ''); ?> <?php if($options->label()) echo l('fields.modules.module.delete'); ?>
</a>
