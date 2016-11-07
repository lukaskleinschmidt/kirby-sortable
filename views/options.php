<?php
  $i = $field->modules()->indexOf($module);
  $n = $field->modules()->slice(0, $i)->visible()->count();
?>
<nav class="dropdown dropdown-dark contextmenu">
  <ul class="nav nav-list dropdown-list">
    <li><a href="<?php echo $module->url('edit'); ?>"><?php i('pencil', 'left'); ?>Edit</a></li>
    <li><a href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal><?php i('trash-o', 'left'); ?>Delete this module</a></li>
    <!-- <li><button type="button" data-action="<?php echo $field->url('duplicate', array('uid' => $module->uid(), 'to' => $i + 2)); ?>"><?php i('clone', 'left'); ?>Duplicate</button></li> -->
    <!-- <li><button type="button" data-action="<?php echo $field->url('show', array('uid' => $module->uid(), 'to' => $n + 1)); ?>"><?php i('toggle-off', 'left'); ?>Show this module</a></li> -->
    <!-- <li><button type="button" data-action="<?php echo $field->url('hide', array('uid' => $module->uid())); ?>"><?php i('toggle-on', 'left'); ?>Hide this module</button></li> -->
    <!-- <li><a href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal><?php i('copy', 'left'); ?>Copy</button></li> -->
    <!-- <li><a href="<?php echo $field->url('delete', array('uid' => $module->uid())); ?>" data-modal><?php i('paste', 'left'); ?>Paste</a></li> -->
  </ul>
</nav>
