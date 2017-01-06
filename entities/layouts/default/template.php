<div class="entity__default">
  <nav class="entity__navigation">
    <div class="entity__title" data-handle>
      <div class="entity__icon">
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
