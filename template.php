<div class="modules<?php e($field->readonly(), ' modules-readonly') ?>" data-field="modules" data-api="<?php __($field->url('sort')); ?>" data-style="<?php echo $field->style(); ?>">
  <?php echo $field->headline(); ?>
  <?php echo $field->label(); ?>

  <?php if(!$field->modules()->count()): ?>

  <div class="modules-empty"> 
    <?php _l('fields.structure.empty') ?> <a data-modal class="modules-add-button" href="<?php __($field->url('add')); ?>"><?php _l('fields.structure.add.first') ?></a>
  </div>

  <?php else: ?>
  <div>
    <div class="modules-entries">
      <?php
        $modules = $field->modules()->visible();
        $count   = $modules->count(); 
      ?>
      <h3>Visible modules <span class="counter">( <?php echo $count; ?> )</span></h3>
      <div class="modules-dropzone" data-entries="visible" data-count="<?php echo $count; ?>">
        <?php echo $field->entries($field->style(), array('modules' => $modules, 'field' => $field)); ?>
      </div>

      <?php if(!$count): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        Drag invisible modules here to sort them/make them visible.
      </div>
      <?php endif; ?>
    </div>

    <div class="modules-entries">
      <?php
        $modules = $field->modules()->invisible();
        $count   = $modules->count(); 
      ?>
      <h3>Invisible modules <span class="counter">( <?php echo $count; ?> )</span></h3>
      <div class="modules-dropzone" data-entries="invisible" data-count="<?php echo $count; ?>">
        <?php echo $field->entries($field->style(), array('modules' => $modules, 'field' => $field)); ?>
      </div>

      <?php if(!$count): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        Drag visible modules here to unsort them/make them invisible. 
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif ?>
</div>