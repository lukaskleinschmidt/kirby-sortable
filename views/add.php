<div class="modal-content modal-content-medium" data-options='<?php echo json_encode($options);?>'>
  <?php echo $form ?>
</div>
<script>
  (function($) {
    var modal = $('.modal-content'), form = $('form', modal), options = modal.data('options');
    var modules = options.modules.map(function(module) {
      module.redirect = module.options.redirect ? '' : options.redirect;
      return module;
    });

    form.on('submit', function(event) {
      var template = $('select[name="template"] option:selected', this).val();
      var module = modules.find(function(module) {
        return module.template == template;
      });

      // Set correct title
      $('input[name="title"]', modal).val(module.title);

      // Set redirect
      $('input[name="_redirect"]', modal).val(module.redirect);
    });
  })(jQuery);
</script>