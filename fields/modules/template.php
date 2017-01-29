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
      echo $field->l('field.sortable.empty');
      if($field->add()) {

        // TEMP: should be a one liner when https://github.com/getkirby/toolkit/pull/217 gets merged
        // echo $field->action('add', ['label' => $field->l('field.sortable.add.first'), 'icon' => ''])->content()->removeAttr('class');
        $add = $field->action('add', ['label' => $field->l('field.sortable.add.first'), 'icon' => ''])->content();
        $add->removeAttr('class');

        echo $add;

        if($field->paste()) {
          echo $field->l('field.sortable.or');

          // TEMP: should be a one liner when https://github.com/getkirby/toolkit/pull/217 gets merged
          // echo $field->action('paste', ['label' => $field->l('field.sortable.paste.first'), 'icon' => ''])->content()->removeAttr('class');
          $paste = $field->action('paste', ['label' => $field->l('field.sortable.paste.first'), 'icon' => ''])->content();
          $paste->removeAttr('class');

          echo $paste;
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
