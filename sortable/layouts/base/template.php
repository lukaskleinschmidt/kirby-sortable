<div class="sortable-entry__default">
  <nav class="sortable-entry__navigation">
    <div class="sortable-entry__icon" title="<?= l('pages.show.template') . ': ' . i18n($layout->blueprint()->title()); ?>" data-handle>
      <?= $layout->icon(); ?>
    </div>
    <div class="sortable-entry__title" title="<?= $layout->title(); ?>" data-handle>
      <?= $layout->title(); ?>
      <?= $layout->counter(); ?>
    </div>
    <?= $layout->action('edit'); ?>
    <?= $layout->action('delete'); ?>
    <?= $layout->action('duplicate'); ?>
    <?= $layout->action('toggle'); ?>
  </nav>
</div>
