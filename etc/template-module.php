<div class="modules-entry" data-uid="<?php echo __($page->uid()); ?>" data-template="<?php echo $module->template(); ?>">
  <?php if($module->preview) echo $module->preview(); ?>
  <nav class="modules-entry-options">
    <span class="modules-entry-title">
      <?php echo $page->icon(); ?>
      <?php echo $page->title(); ?>
      <?php if($page->isVisible() && $module->limit) echo $module->counter(); ?>
    </span>
    <?php if ($module->edit && !$field->readonly): ?>
    <a class="modules-entry-button btn btn-with-icon modules-edit-button" href="<?php __($module->url('edit')); ?>">
      <?php if($module->label): ?>
        <?php i('pencil', 'left') . _l('fields.modules.edit') ?>
      <?php else: ?>
        <?php i('pencil') ?>
      <?php endif; ?>
    </a>
    <?php endif; ?>
    <?php if ($module->delete && !$field->readonly): ?>
    <a data-modal class="modules-entry-button btn btn-with-icon modules-delete-button" href="<?php __($module->url('delete')); ?>">
      <?php if($module->label): ?>
        <?php i('trash-o', 'left') . _l('fields.modules.delete') ?>
      <?php else: ?>
        <?php i('trash-o') ?>
      <?php endif; ?>
    </a>
    <?php endif; ?>
  </nav>
</div>
