<div class="element__default">
  <nav class="element__navigation">
    <div class="element__title" data-handle>
      <div class="element__icon">
        <?= $element->page()->icon('left'); ?>
      </div>
      <?= $element->page()->title(); ?>
      <?= $element->counter(); ?>
    </div>
    <?= $element->action('edit'); ?>
    <?= $element->action('delete'); ?>
    <?= $element->action('duplicate'); ?>
    <?= $element->action('toggle'); ?>
  </nav>
</div>
