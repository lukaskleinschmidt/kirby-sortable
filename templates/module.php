<?php foreach($modules as $module): ?>
<div class="modules-entry" data-uid="<?php echo __($module->uid()); ?>">
  <?php if($field->option($module, 'preview')) echo $field->preview($module); ?>
  <nav class="modules-entry-options">
    <span class="modules-entry-title">
      <?php echo $module->icon(); ?>
      <?php echo $module->title(); ?>
    </span>
    <?php if ($field->option($module, 'edit')): ?>
    <a class="modules-entry-button btn btn-with-icon modules-edit-button" href="<?php __($module->url('edit')); ?>">
      <?php i('pencil', 'left') . _l('fields.modules.edit') ?>
    </a>
    <?php endif; ?>
    <?php if ($field->option($module, 'delete')): ?>
    <a data-modal class="modules-entry-button btn btn-with-icon modules-delete-button" href="<?php __($field->url('delete', array('uid' => $module->uid()))); ?>">
      <?php i('trash-o', 'left') . _l('fields.modules.delete') ?>
    </a>
    <?php endif; ?>
  </nav>
</div>          
<?php endforeach ?>