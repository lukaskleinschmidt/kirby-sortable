<div class="module">

  <nav class="module__navigation">
    <div class="module__title">
      <div class="module__icon">
        <?php echo $entity->page()->icon('left'); ?>
      </div>
      <?php echo $entity->page()->title(); ?>
      <?php echo $entity->counter(); ?>

      <?php echo $entity->action('delete'); ?>
    </div>
  </nav>

</div>
