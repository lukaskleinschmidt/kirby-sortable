<div class="modules-entries">
  <h3><?php _l('fields.modules.' . $status) ?> <?php echo $field->counter($count, $limit); ?></h3>

  <div class="modules-dropzone" data-entries="<?php echo $status; ?>" data-count="<?php echo $count; ?>">
    <?php $field->modules($pages); ?>
  </div>

  <?php if(!$count && !$field->readonly()): ?>
  <div class="subpages-help subpages-help-left marginalia text">
    <?php _l('fields.modules.' . $status . '.info') ?>
  </div>
  <?php endif; ?>
</div>