<div class="modules" data-field="modules">
  <?php foreach($field->modules() as $module): ?>
    <div class="module" data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>" data-uid="<?php echo $module->uid(); ?>">
      <?php if(true): ?>
        <div class="module__preview">

          <?php echo $field->url('sort'); ?>

        </div>
      <?php endif; ?>
      <nav class="module__options">
        <div class="module__title">
          <?php echo $module->icon(); ?>
          <!-- <a href="#">
            <i class="icon fa fa-ellipsis-h"></i>
          </a> -->
          <?php echo $module->title(); ?>
        </div>
        <div class="module__buttons">
          <a href="<?php echo $module->url('edit'); ?>"><i class="icon icon-left fa fa-pencil"></i> Edit</a>
          <a href=""><i class="icon icon-left fa fa-trash-o"></i> Delete</a>
          <?php if($module->isVisible()): ?>
            <button class="" data-hide><i class="icon icon-left fa fa-toggle-on"></i></button>
          <?php else: ?>
            <button class="" data-show><i class="icon icon-left fa fa-toggle-off"></i></button>
          <?php endif; ?>
        </div>
      </nav>
      <?php echo $field->input($module->uid()); ?>
    </div>
  <?php endforeach; ?>
</div>
