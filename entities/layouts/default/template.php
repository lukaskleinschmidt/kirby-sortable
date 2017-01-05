<div class="module">
  <nav class="module__navigation">
    <div class="module__title">
      <div class="module__icon">
        <?= $entity->page()->icon('left'); ?>
      </div>
      <?= $entity->page()->title(); ?>
      <?= $entity->counter(); ?>
    </div>
    <?= $entity->action('edit', ['label' => 'lorem']); ?>
    <?= $entity->action('delete'); ?>
    <?= $entity->action('duplicate'); ?>
    <?= $entity->action('toggle'); ?>
  </nav>
</div>
