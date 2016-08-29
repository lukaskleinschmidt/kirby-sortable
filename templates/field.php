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
    <div class="modules-entries">
      <?php
        $pages = $field->pages()->visible();
        $count = $pages->count(); 
      ?>
      <h3><?php _l('fields.modules.visible') ?> <?php echo $field->counter($count, true); ?></h3>

      <div class="modules-dropzone" data-entries="visible" data-count="<?php echo $count; ?>">
        <?php $field->modules($pages); ?>
      </div>

      <?php if(!$count && !$field->readonly()): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        <?php _l('fields.modules.visible.info') ?>
      </div>
      <?php endif; ?>
    </div>

    <div class="modules-entries">
      <?php
        $pages = $field->pages()->invisible();
        $count = $pages->count(); 
      ?>
      <h3><?php _l('fields.modules.invisible') ?> <?php echo $field->counter($count); ?></h3>

      <div class="modules-dropzone" data-entries="invisible" data-count="<?php echo $count; ?>">
        <?php $field->modules($pages); ?>
      </div>

      <?php if(!$count && !$field->readonly()): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        <?php _l('fields.modules.invisible.info') ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php endif ?>
  
</div>