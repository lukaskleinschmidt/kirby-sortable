<a class="<?= $action->class(); ?><?php if($action->disabled()) echo ' is-disabled'; ?>" data-modal href="<?= $action->url(); ?>">
  <?= $action->icon('left'); ?><?= $action->label(); ?>
</a>
