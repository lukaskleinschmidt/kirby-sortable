<a class="element__action<?php if($action->disabled()) echo ' is-disabled'; ?>" href="<?= $action->page()->url('edit'); ?>" title="<?= $action->title(); ?>">
  <?= $action->icon(); ?>
</a>
