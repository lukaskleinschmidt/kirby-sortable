<a class="module__action<?php if($action->isDisabled()) echo ' is-disabled'; ?>" href="<?php echo $action->url('delete', [$action->page()->uid()]); ?>" data-modal title="<?php echo l('fields.modules.module.delete'); ?>">
  <?php i('trash-o'); ?>
</a>
