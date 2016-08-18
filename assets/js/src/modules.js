import Sortable from 'sortablejs';

(function($) {

  class Modules {
    constructor(element) {
      this.element = $(element);
      this.animation = 0;
      this.containment = $('.main');

      this.create('visible', ['invisible']);
      this.create('invisible', ['visible']);
      
      console.log(this);
    }

    create(name, put) {
      var element = $('.modules-dropzone[data-entries="' + name + '"]', this.element);
      Sortable.create(element.get(0), {
        forceFallback: true,
        group: {
          name: name,
          put: put
        },
        animation: this.animation
      });
    }
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
