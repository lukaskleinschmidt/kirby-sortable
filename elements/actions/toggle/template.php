<a class="element__action<?php if($action->isDisabled()) echo ' is-disabled'; ?>" href="<?php echo $action->url('toggle', $action->params()); ?>" data-action title="<?= $action->title() ?>">
  <?= $action->icon() ?>
</a>
