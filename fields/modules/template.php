<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?php if($field->add()) echo $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="sortable__empty">
    <?php
      echo $field->l('field.sortable.empty');
      if($field->add()) {
        echo $field->action('add', ['label' => $field->l('field.sortable.add.first'), 'icon' => '', 'class' => '']);
        if($field->paste()) {
          echo $field->l('field.sortable.or');
          echo $field->action('paste', ['label' => $field->l('field.sortable.paste.first'), 'icon' => '', 'class' => '']);
        }
      }
    ?>
  </div>
<?php endif; ?>

<div class="sortable__navigation">
  <?php
    if($field->copy()) echo $field->action('copy');
    if($field->add()) {
      if($field->paste()) echo $field->action('paste');
      echo $field->action('add');
    }
  ?>
</div>
