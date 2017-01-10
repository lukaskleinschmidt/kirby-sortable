<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?= $field->action('add'); ?>
</label>

<?php if($field->hasElements()): ?>
  <?= $field->elements(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?= l('fields.modules.empty'); ?>
    <?= $field->action('add', ['label' => l('fields.modules.empty.add'), 'icon' => '', 'class' => '']); ?>
    <?= l('fields.modules.empty.or'); ?>
    <?= $field->action('paste', ['label' => l('fields.modules.empty.paste'), 'icon' => '', 'class' => '']); ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
