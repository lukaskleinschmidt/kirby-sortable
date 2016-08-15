<div class="modules<?php e($field->readonly(), ' modules-readonly') ?>" data-field="modules" data-api="<?php __($field->modulesRoot()->url('subpages')); ?>" data-style="<?php echo $field->style(); ?>">
  <?php if(!$field->modules()->count()): ?>

  <div class="modules-empty"> 
    <?php _l('fields.modules.empty') ?> <a data-modal class="modules-add-button" href="<?php __($field->url('add')); ?>"><?php _l('fields.modules.add.first') ?></a>
  </div>

  <?php else: ?>
  <div>
    <div class="modules-entries">
      <?php
        $modules = $field->modules()->visible();
        $count   = $modules->count(); 
      ?>
      <h3><?php _l('fields.modules.visible') ?> <span class="counter">( <?php echo $count; ?> )</span></h3>
      <div class="modules-dropzone" data-entries="visible" data-count="<?php echo $count; ?>">
        <?php echo $field->entries($field->style(), array('modules' => $modules, 'field' => $field)); ?>
      </div>

      <?php if(!$count && !$field->readonly()): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        <?php _l('fields.modules.visible.info') ?>
      </div>
      <?php endif; ?>
    </div>

    <div class="modules-entries">
      <?php
        $modules = $field->modules()->invisible();
        $count   = $modules->count(); 
      ?>
      <h3><?php _l('fields.modules.invisible') ?> <span class="counter">( <?php echo $count; ?> )</span></h3>
      <div class="modules-dropzone" data-entries="invisible" data-count="<?php echo $count; ?>">
        <?php echo $field->entries($field->style(), array('modules' => $modules, 'field' => $field)); ?>
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