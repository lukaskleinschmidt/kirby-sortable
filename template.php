<div id="<?php echo $field->id(); ?>" class="modules" data-field="modules" data-api="<?php echo purl($field->model(), implode('/', array('field', $field->name(), 'modules'))); ?>">

  <?php $i = 0; $n = 0; foreach($field->modules() as $module): $i++; if($module->isVisible()) $n++; ?>
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
        <a class="module__button" href="<?php echo $module->url('edit'); ?>" title="Edit"><?php i('pencil', 'left'); ?> Edit</a>
        <a class="module__button" href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal title="Delete"><i class="icon icon-left fa fa-trash-o"></i> Delete</a>
        <button class="module__button" data-action="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 1)); ?>" type="button" tabindex="-1"><?php i('copy'); ?></button>
        <?php if($module->isVisible()): ?>
          <button class="module__button" data-action="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" type="button" tabindex="-1"><?php i('toggle-on'); ?></button>
          <!-- <a href="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>" class="module__button" data-modal title="Hide"><?php i('toggle-on'); ?></i></a> -->
        <?php else: ?>
          <button class="module__button" data-action="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" type="button" tabindex="-1"><?php i('toggle-off'); ?></button>
          <!-- <a href="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>" class="module__button" data-modal title="Show"><?php i('toggle-off'); ?></a> -->
        <?php endif; ?>
      </nav>

      <?php echo $field->input($module->uid()); ?>
    </div>
  <?php endforeach; ?>

  <!-- <div class="modules__add">
    <a href="#" class="label-option" data-context><?php i('plus-circle', 'left'); ?>Add</a>
  </div> -->

</div>
