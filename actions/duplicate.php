<?php if($options->duplicate()): ?>
<a class="module__button" href="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 1)); ?>" data-action title="<?php echo l('fields.modules.module.duplicate'); ?>">
  <?php i('clone'); ?>
</a>
<?php endif; ?>
