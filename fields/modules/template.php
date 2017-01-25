<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?php if($field->add()) echo $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?= l('fields.modules.empty'); ?>Everything is empty!
    <?php if($field->add()): ?>
      <?= $field->action('add', ['label' => l('fields.modules.empty.add'), 'icon' => '', 'class' => '']); ?> add
      <?php if($field->paste()): ?>
        <?= l('fields.modules.empty.or'); ?> or
        <?= $field->action('paste', ['label' => l('fields.modules.empty.paste'), 'icon' => '', 'class' => '']); ?> paste
      <?php endif; ?>
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?php if($field->copy()) echo $field->action('copy'); ?>
  <?php if($field->paste() && $field->add()) echo $field->action('paste'); ?>
  <?php if($field->add()) echo $field->action('add'); ?>
</div>
