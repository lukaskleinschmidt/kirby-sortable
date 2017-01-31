<div class="sortable-layout">
  <nav class="sortable-layout__navigation">
    <div class="sortable-layout__icon" title="<?= l('pages.show.template') . ': ' . i18n($layout->blueprint()->title()); ?>" data-handle>
      <?= $layout->icon(); ?>
    </div>
    <div class="sortable-layout__title" title="<?= $layout->title(); ?>" data-handle>
      <?= $layout->title(); ?>
      <?= $layout->counter(); ?>
    </div>
    <?= $layout->action('edit'); ?>
    <?= $layout->action('delete'); ?>
    <?= $layout->action('duplicate'); ?>
    <?= $layout->action('toggle'); ?>
  </nav>
</div>
