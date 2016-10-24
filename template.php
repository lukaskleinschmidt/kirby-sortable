<div class="modules" data-field="modules">
  <?php foreach($field->modules() as $module): ?>
    <div class="module" data-visible="<?php echo $module->isVisible() ? 'true' : 'false'; ?>">
      <?php if(true): ?>
        <div class="module__preview">

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
          <button type="button" name="button"><i class="icon icon-left fa fa-pencil"></i> Edit</button>
          <button type="button" name="button"><i class="icon icon-left fa fa-trash-o"></i> Delete</button>
          <?php if($module->isVisible()): ?>
            <button type="button" name="button"><i class="icon icon-left fa fa-toggle-on"></i></button>
          <?php else: ?>
            <button type="button" name="button"><i class="icon icon-left fa fa-toggle-off"></i></button>
          <?php endif; ?>
        </div>
      </nav>
      <?php echo $field->input($module->uid()); ?>
    </div>
  <?php endforeach; ?>
</div>
