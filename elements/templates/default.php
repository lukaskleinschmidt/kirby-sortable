<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?= $field->action('add'); ?>
</label>

<?php if($field->hasElements()): ?>
  <?= $field->elements(); ?>
<?php else: ?>
  <div class="elements__empty">
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

<div class="elements__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
