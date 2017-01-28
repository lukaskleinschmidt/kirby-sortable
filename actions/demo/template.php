<a class="element__action<?php if($action->disabled()) echo ' is-disabled'; ?>" href="<?= $action->url([$action->page()->uid()]); ?>" data-modal title="<?= $action->title(); ?>">
  <?= $action->icon(); ?>
</a>
