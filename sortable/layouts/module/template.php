<div class="sortable-layout">
  <?php if($layout->preview === true || $layout->preview === 'top') echo $layout->preview(); ?>
  <nav class="sortable-layout__navigation">
    <div class="sortable-layout__icon" title="<?= l('pages.show.template') . ': ' . i18n($layout->blueprint()->title()); ?>" data-handle>
      <?= $layout->icon(); ?>
    </div>
    <div class="sortable-layout__title" title="<?= $layout->title(); ?>" data-handle>
      <?= $layout->title(); ?>
      <?= $layout->counter(); ?>
    </div>
    <?php foreach($layout->field()->actions() as $action): ?>
      <?= $layout->action($action); ?>
    <?php endforeach; ?>
  </nav>
  <?php if($layout->preview === 'bottom') echo $layout->preview(); ?>
</div>
