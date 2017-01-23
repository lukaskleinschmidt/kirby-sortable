<a class="element__action<?php if($action->disabled()) echo ' is-disabled'; ?>" href="<?php echo $action->url($action->params()); ?>" data-action title="<?= $action->title() ?>">
  <?= $action->icon() ?>
</a>
