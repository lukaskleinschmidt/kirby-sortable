<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?= $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?= $field->l('fields.sortable.empty'); ?>
    <?= $field->action('add', ['label' => $field->l('fields.sortable.add.first', 'modules'), 'icon' => '', 'class' => '']); ?>
    <?= $field->l('fields.sortable.or'); ?>
    <?= $field->action('paste', ['label' => $field->l('fields.sortable.paste.first'), 'icon' => '', 'class' => '']); ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
