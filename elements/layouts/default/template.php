<div class="element__default">
  <nav class="element__navigation">
    <div class="element__icon" title="<?= l('pages.show.template') . ': ' . i18n($element->blueprint()->title()); ?>" data-handle>
      <?= $element->icon(); ?>
    </div>
    <div class="element__title" title="<?= $element->title(); ?>" data-handle>
      <?= $element->title(); ?>
      <?= $element->counter(); ?>
    </div>
    <?= $element->action('edit'); ?>
    <?= $element->action('delete'); ?>
    <?= $element->action('duplicate'); ?>
    <?= $element->action('toggle'); ?>
  </nav>
</div>
