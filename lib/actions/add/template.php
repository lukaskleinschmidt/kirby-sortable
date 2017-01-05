<a class="entities__action entities__action--add<?php if($action->isDisabled()) echo ' is-disabled'; ?>" data-modal href="<?php echo $action->url('add'); ?>">
  <?php i('plus-circle', 'left'); ?><?php echo $action->label(); ?>
</a>
