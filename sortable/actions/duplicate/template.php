<a class="element__action<?php if($action->disabled()) echo ' is-disabled'; ?>" href="<?php echo $action->url([$action->page()->uid(), $action->layout()->num() + 1]); ?>" data-action title="<?= $action->title() ?>">
  <?= $action->icon() ?>
</a>
