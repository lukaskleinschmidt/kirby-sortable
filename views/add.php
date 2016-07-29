<div class="modal-content modal-content-medium">
  <?php echo $form ?>
</div>
<script>
  (function($) {
    var modal  = $('.modal-content');
    var title  = $('input[name="title"]', modal);
    var select = $('select[name="template"]', modal);

    select.on('change', function(event) {
      title.val($('option:selected', this).text());
    });
  })(jQuery);
</script>