<?php if($module->isVisible()): ?>
  <a class="module__button" href="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" data-action title="<?php echo l('fields.modules.module.hide'); ?>">
    <?php i('toggle-on'); ?>
  </a>
<?php endif; ?>
