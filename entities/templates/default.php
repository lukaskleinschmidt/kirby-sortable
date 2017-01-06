<?= $field->label()->append($field->action('add')); ?>

<?php if($field->hasEntities()): ?>

  <?= $field->entities(); ?>

<?php else: ?>

  <div class="modules__empty">
    <?php echo l('fields.modules.empty'); ?>
    <?php if($field->add()): ?>
      <a href="<?php echo $field->url('add'); ?>" data-modal><?php echo l('fields.modules.empty.add'); ?></a>
    <?php endif; ?>
    <?php if($field->add() && $field->paste()): ?>
      <?php echo l('fields.modules.empty.or'); ?>
      <a href="<?php echo $field->url('paste'); ?>" data-modal data-shortcut="meta+v"><?php echo l('fields.modules.empty.paste'); ?></a>
    <?php endif; ?>
  </div>

<?php endif; ?>

<div class="entities__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
