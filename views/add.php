<div class="modal-content modal-content-medium" data-options='<?php echo json_encode($options);?>'>
  <?php echo $form ?>
</div>
<script>
  (function($) {
    var modal = $('.modal-content'), form = $('form', modal), options = modal.data('options');
    var templates = options.templates.map(function(template) {
      template.redirect = template.options.redirect ? '' : options.redirect;
      return template;
    });

    console.log(options);
    console.log(templates);

    form.on('submit', function(event) {
      var name = $('select[name="template"] option:selected', this).val();
      var template = templates.find(function(template) {
        return template.name == name;
      });

      // Set correct title
      $('input[name="title"]', modal).val(template.title);

      // Set redirect
      $('input[name="_redirect"]', modal).val(template.redirect);
    });
  })(jQuery);
</script>