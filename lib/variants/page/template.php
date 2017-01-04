<div class="module">

  <nav class="module__navigation">
    <div class="module__title">
      <div class="module__icon">
        <?php echo $entity->page()->icon('left'); ?>
      </div>
      <?php echo $entity->page()->title(); ?>
      <?php echo $entity->counter(); ?>

      <?php // echo $entity->field()->counter($entity->page()); ?>
      <?php // echo $entity->action('delte'); ?>
    </div>
  </nav>

</div>
