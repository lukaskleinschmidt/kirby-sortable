<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?= $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?= l('fields.modules.empty'); ?>
    <?= $field->action('add', ['label' => $field->l('fields.modules.empty.add'), 'icon' => '', 'class' => '']); ?>
    <?= l('fields.modules.empty.or'); ?>
    <?= $field->action('paste', ['label' => $field->l('fields.modules.empty.paste'), 'icon' => '', 'class' => '']); ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
