<?php /*<nav class="dropdown dropdown-dark contextmenu">
  <ul class="nav nav-list dropdown-list">
    <li><a href="http://www.kirby.dev/home/subpage-2" target="_blank" title="p" data-shortcut="p"><i class="icon icon-left fa fa-play-circle-o"></i>Open preview</a></li>
    <li><a href="http://www.kirby.dev/panel/pages/home/subpage-2/edit"><i class="icon icon-left fa fa-pencil"></i>Edit</a></li>
    <li><a href="http://www.kirby.dev/panel/pages/home/subpage-2/toggle?_redirect=pages/home/edit" data-modal=""><i class="icon icon-left fa fa-toggle-on"></i>Status: visible</a></li>
    <li><a href="http://www.kirby.dev/panel/pages/home/subpage-2/url?_redirect=pages/home/edit" title="u" data-shortcut="u" data-modal=""><i class="icon icon-left fa fa-chain"></i>Change URL</a></li>
    <li><a href="http://www.kirby.dev/panel/pages/home/subpage-2/delete?_redirect=pages/home/edit" title="#" data-shortcut="#" data-modal=""><i class="icon icon-left fa fa-trash-o"></i>Delete this page</a></li>
  </ul>
</nav>*/ ?>
<div class="modal-content modal-content-small" data-options='<?php echo json_encode($options);?>'>
  <?php echo $form ?>
</div>
<?php /*
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
</script> */ ?>
