<div class="element__default">
  <nav class="element__navigation">
    <div class="element__icon" title="<?= l('pages.show.template') . ': ' . i18n($layout->blueprint()->title()); ?>" data-handle>
      <?= $layout->icon(); ?>
    </div>
    <div class="element__title" title="<?= $layout->title(); ?>" data-handle>
      <?= $layout->title(); ?>
      <?= $layout->counter(); ?>
    </div>
    <?= $layout->action('edit'); ?>
    <?= $layout->action('delete'); ?>
    <?= $layout->action('duplicate'); ?>
    <?= $layout->action('toggle'); ?>
  </nav>
</div>
