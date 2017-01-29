<label class="label">
  <?= $field->label(); ?>
  <?= $field->counter(); ?>
  <?= $field->action('add'); ?>
</label>

<?php if($field->entries()->count()): ?>
  <?= $field->layouts(); ?>
<?php else: ?>
  <div class="elements__empty">
    <?= $field->l('field.sortable.empty'); ?>
    <?php
      // TEMP: should be a one liner when https://github.com/getkirby/toolkit/pull/217 gets merged
      // echo $field->action('add', ['label' => $field->l('field.sortable.add.first'), 'icon' => ''])->content()->removeAttr('class');
      $add = $field->action('add', ['label' => $field->l('field.sortable.add.first'), 'icon' => ''])->content();
      $add->removeAttr('class');

      echo $add;
    ?>
    <?= $field->l('field.sortable.or'); ?>
    <?php
      // TEMP: should be a one liner when https://github.com/getkirby/toolkit/pull/217 gets merged
      // echo $field->action('paste', ['label' => $field->l('field.sortable.paste.first'), 'icon' => ''])->content()->removeAttr('class');
      $paste = $field->action('paste', ['label' => $field->l('field.sortable.paste.first'), 'icon' => ''])->content();
      $paste->removeAttr('class');

      echo $paste;
    ?>
  </div>
<?php endif; ?>

<div class="elements__navigation">
  <?= $field->action('copy'); ?>
  <?= $field->action('paste'); ?>
  <?= $field->action('add'); ?>
</div>
