<?= $field->label()->append($field->action('add', ['align' => 'right'])); ?>

<?php if($field->hasEntities()): ?>
  <?= $field->entities(); ?>
<?php else: ?>
  Nothing found
<?php endif; ?>

<div class="entities__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add', ['align' => 'right']); ?>
</div>
