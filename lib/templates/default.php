<label>
  <?php echo $field->label(); ?>
  <?php echo $field->action('add', ['align' => 'right']); ?>
</label>

<?php if($field->hasEntities()): ?>
  <?php echo $field->entities(); ?>
<?php else: ?>
  Nothing found
<?php endif; ?>

<div class="entities__navigation">
  <?php echo $field->action('copy'); ?>
  <?php echo $field->action('paste'); ?>
  <?php echo $field->action('add', ['align' => 'right']); ?>
</div>
