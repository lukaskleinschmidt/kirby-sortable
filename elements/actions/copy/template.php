<a class="elements__action elements__action--copy<?php if($action->isDisabled()) echo ' is-disabled'; ?>" data-modal href="<?= $action->url('copy'); ?>">
  <?= $action->icon('left'); ?><?= $action->label(); ?>
</a>
