<a class="element__action<?php if($action->isDisabled()) echo ' is-disabled'; ?>" href="<?= $action->url('delete', [$action->page()->uid()]); ?>" data-modal title="<?= $action->title(); ?>">
  <?= $action->icon(); ?>
</a>
