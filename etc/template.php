<div class="modules<?php e($field->readonly(), ' modules-readonly') ?>"
  data-field="modules"
  data-options='<?php echo $field->data(); ?>'
  data-api="<?php __($field->origin()->url('subpages')); ?>"
  data-style="<?php echo $field->style(); ?>">
  
  <?php if(!$field->pages()->count()): ?>

  <div class="modules-empty"> 
    <?php _l('fields.modules.empty') ?>
    <a data-modal class="modules-add-button" href="<?php __($field->url('add')); ?>"><?php _l('fields.modules.add.first') ?></a>
  </div>

  <?php else: ?>

  <div>
    <?php echo $field->entries(); ?> 
    <?php echo $field->entries(false); ?> 
  </div>

  <?php endif ?>
  
</div>