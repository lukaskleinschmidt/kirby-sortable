<div class="modules" data-field="modules" data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>">

  <?php $n = 0; foreach($field->modules() as $module): if($module->isVisible()) $n++; ?>
    <div class="module" data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>" data-uid="<?php echo $module->uid(); ?>">

      <?php if(true): ?>
        <!-- <div class="module__preview">
          <?php echo $field->url('sort'); ?>
        </div> -->
      <?php endif; ?>

      <nav class="module__navigation">
        <div class="module__title">
          <?php echo $module->icon(); ?>
          <!-- <a href="#">
            <i class="icon fa fa-ellipsis-h"></i>
          </a> -->
          <?php echo $module->title(); ?>
        </div>
        <a class="module__button" href="<?php echo $module->url('edit'); ?>" title="Edit"><i class="icon icon-left fa fa-pencil"></i> Edit</a>
        <!-- <a class="module__button" href="" title="Delete"><i class="icon icon-left fa fa-trash-o"></i> Delete</a> -->
        <!-- <button class="module__button"><i class="icon fa fa-copy"></i></button> -->
        <?php if($module->isVisible()): ?>
          <a href="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" class="module__button" data-modal title="Hide"><i class="icon fa fa-toggle-on"></i></a>
        <?php else: ?>
          <a href="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" class="module__button" data-modal title="Show"><i class="icon fa fa-toggle-off"></i></a>
        <?php endif; ?>
      </nav>

      <?php echo $field->input($module->uid()); ?>
    </div>
  <?php endforeach; ?>

</div>
