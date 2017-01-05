<a class="entities__action entities__action--paste<?php if($action->isDisabled()) echo ' is-disabled'; ?>" data-modal href="<?= $action->url('paste'); ?>">
  <?= $action->icon('left'); ?><?= $action->label(); ?>
</a>
