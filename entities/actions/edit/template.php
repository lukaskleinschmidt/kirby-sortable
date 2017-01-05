<a class="module__action<?php if($action->isDisabled()) echo ' is-disabled'; ?>" href="<?= $action->page()->url('edit'); ?>" title="<?= $action->title(); ?>">
  <?= $action->icon(); ?>
</a>
