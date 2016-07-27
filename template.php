<div class="grey subpages-grid structure<?php e($field->readonly(), ' structure-readonly') ?>" data-field="modules" data-api="<?php __($field->url('sort')); ?>" data-sortable="true">

  <?php echo $field->headline(); ?>
  <?php echo $field->label(); ?>

    <?php if(!$field->modules()->count()): ?>

    <div class="structure-empty"> 
      <?php _l('fields.structure.empty') ?> <a data-modal class="structure-add-button" href="<?php __($field->url('add')); ?>"><?php _l('fields.structure.add.first') ?></a>
    </div>

    <?php else: ?>

    <h3>Sichtbare Module ( <?php echo $field->modules()->visible()->count(); ?> )</h3>
    <div class="module-entries dropzone subpages">
      <?php foreach($field->modules()->visible() as $module): ?>
      <div class="structure-entry" id="structure-entry-<?php echo $module->id() ?>" data-uid="<?php echo __($module->uid()); ?>"<?php echo $module->isInvisible() ? ' style="opacity: 0.5;"' : ''; ?>>
        <div class="structure-entry-content text">
          <?php echo $field->entry($module); ?>
        </div>
        <?php if(!$field->readonly()): ?>
        <nav class="structure-entry-options cf">
          <a class="btn btn-with-icon structure-edit-button" href="<?php __($module->url('edit')); ?>">
            <?php i('pencil', 'left') . _l('fields.structure.edit') ?>
          </a>
          <a data-modal class="btn btn-with-icon structure-delete-button" href="<?php __($field->url('delete', array('uid' => $module->uid()))); ?>">
            <?php i('trash-o', 'left') . _l('fields.structure.delete') ?>
          </a>
        </nav>
        <?php endif ?>
      </div>          
      <?php endforeach ?>
    </div>

    <h3>Unsichtbare Module ( <?php echo $field->modules()->invisible()->count(); ?> )</h3>
    <div class="module-entries dropzone subpages">
      <?php foreach($field->modules()->invisible() as $module): ?>
      <div class="structure-entry" id="structure-entry-<?php echo $module->id() ?>" data-uid="<?php echo __($module->uid()); ?>"<?php echo $module->isInvisible() ? ' style="opacity: 0.5;"' : ''; ?>>
        <div class="structure-entry-content text">
          <?php echo $field->entry($module); ?>
        </div>
        <?php if(!$field->readonly()): ?>
        <nav class="structure-entry-options cf">
          <a class="btn btn-with-icon structure-edit-button" href="<?php __($module->url('edit')); ?>">
            <?php i('pencil', 'left') . _l('fields.structure.edit') ?>
          </a>
          <a data-modal class="btn btn-with-icon structure-delete-button" href="<?php __($field->url('delete', array('uid' => $module->uid()))); ?>">
            <?php i('trash-o', 'left') . _l('fields.structure.delete') ?>
          </a>
        </nav>
        <?php endif ?>
      </div>          
      <?php endforeach ?>
      <?php if(!$field->modules()->invisible()->count()): ?>
        <div class="items sortable ui-sortable" id="invisible-children"></div>
      <?php endif; ?>
    </div>
    <?php if(!$field->modules()->invisible()->count()): ?>
      <div class="subpages-help subpages-help-right marginalia text">Ziehe sichtbare Module hierher, um sie unsichtbar zu machen</div>
    <?php endif; ?>
  <?php endif ?>
</div>