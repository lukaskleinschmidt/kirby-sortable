<div class="modal-content modal-content-medium" data-templates='<?php echo json_encode($templates);?>'>
  <?php echo $form ?>
</div>
<script>
  (function($) {
    var modal = $('.modal-content'),
        title = $('input[name="title"]', modal),
        select    = $('select[name="template"]', modal),
        redirect  = $('input[name="_redirect"]', modal),
        templates = modal.data('templates').map(function(index) { return parseInt(index); });

    select.on('change', function(event) {
      var option = $('option:selected', this);
      title.val(option.text());
      update(option.index());
    });

    function update(index) {
      if (templates.indexOf(index) < 0) {
        redirect.attr('name', '');
      } else {
        redirect.attr('name', '_redirect');
      }
    }

    update(0);
  })(jQuery);
</script>