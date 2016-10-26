<div class="modules" data-field="modules">
  <?php foreach($field->modules() as $module): ?>
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
          <button class="module__button" data-hide title="Hide"><i class="icon fa fa-toggle-on"></i></button>
        <?php else: ?>
          <button class="module__button" data-show title="Show"><i class="icon fa fa-toggle-off"></i></button>
        <?php endif; ?>
      </nav>
      <?php echo $field->input($module->uid()); ?>
    </div>
  <?php endforeach; ?>
</div>
