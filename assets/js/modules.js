(function($) {

  // http://stackoverflow.com/questions/14241994/jquery-ui-draggable-not-scrolling-the-sortable-container
  // https://github.com/RubaXa/Sortable

  var Modules = function(el) {
    var element = $(el);
    var api     = element.data('api');
    var entries = $('.module-entries', el);

    entries.sortable({
      // helper: function(e, ui) {
      //   ui.children().each(function() {
      //     $(this).width($(this).width());
      //   });
      //   return ui.addClass('structure-sortable-helper');
      // },
      update: function(e, ui) {
        id = ui.item.data('uid');
        to = ui.item.index() + 1;

        $.post(api, {action: 'sort', id: id, to: to}, function() {
          app.content.reload();
        });
      },
      connectWith: '.module-entries',
      containment: '.mainbar',
      start: function(event, ui) {
        entries.sortable('refreshPositions');
      },
      // Hack to prevent scrollbar bouncing
      // http://stackoverflow.com/questions/1735372/jquery-sortable-list-scroll-bar-jumps-up-when-sorting
      create: function(event, ui) {
        var element = $(this);
        element.css('min-height', element.outerHeight());
      }
    }).disableSelection();

    // $('.structure-add-button').on('click', function(e) {
    //   e.preventDefault();
    //   console.log(api);

    //   $.post(api, {action: 'add', title: 'Title', uid: 'test-uid', template: 'module.text', to: 3}, function() {
    //     app.content.reload();
    //   })
    //   .always(function(data) {
    //     console.log(data);
    //   });

    // });
  }

  $.fn.modules = function() {
    return this.each(function() {
      if($(this).data('modules')) {
        return $(this);
      } else {
        var modules = new Modules(this);
        $(this).data('modules', modules);
        return $(this);
      }
    });
  }

})(jQuery);
