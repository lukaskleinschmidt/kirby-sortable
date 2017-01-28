<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?php if($field->add()) echo $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?php
      echo $field->l('fields.sortable.empty');
      if($field->add()) {
        echo $field->action('add', ['label' => $field->l('fields.sortable.add.first', 'modules'), 'icon' => '', 'class' => '']);
        if($field->paste()) {
          echo $field->l('fields.sortable.or');
          echo $field->action('paste', ['label' => $field->l('fields.sortable.paste.first'), 'icon' => '', 'class' => '']);
        }
      }
    ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?php
    if($field->copy()) echo $field->action('copy');
    if($field->add()) {
      if($field->paste()) echo $field->action('paste');
      echo $field->action('add');
    }
  ?>
</div>
