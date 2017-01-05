<a class="entities__action entities__action--copy<?php if($action->isDisabled()) echo ' is-disabled'; ?>" data-modal href="<?= $action->url('copy'); ?>">
  <?= $action->icon('left'); ?><?= $action->label(); ?>
</a>
