<?php foreach($modules as $module): ?>
<div class="modules-entry" id="modules-entry-<?php echo $module->id() ?>" data-uid="<?php echo __($module->uid()); ?>">
  <div class="modules-entry-content">
    <?php echo $field->entry($module); ?>
  </div>
  <?php if(!$field->readonly()): ?>
  <nav class="modules-entry-options cf">
    <a class="modules-entry-button btn btn-with-icon modules-edit-button" href="<?php __($module->url('edit')); ?>">
      <?php i('pencil', 'left') . _l('fields.structure.edit') ?>
    </a>
    <a data-modal class="modules-entry-button btn btn-with-icon modules-delete-button" href="<?php __($field->url('delete', array('uid' => $module->uid()))); ?>">
      <?php i('trash-o', 'left') . _l('fields.structure.delete') ?>
    </a>
  </nav>
  <?php endif ?>
</div>          
<?php endforeach ?>