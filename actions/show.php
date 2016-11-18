<?php if($module->isInvisible()): ?>
  <a class="module__button" href="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" data-action title="<?php echo l('fields.modules.module.show'); ?>">
    <?php i('toggle-off'); ?>
  </a>
<?php endif; ?>
