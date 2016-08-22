import Sortable from 'sortablejs';

(function($) {

  class Modules {
    constructor(element) {
      this.element = $(element);
      this.animation = 0;
      this.containment = $('.main');
      this.config = this.element.data('config');

      this.visible = this.create('visible', ['invisible']);
      this.invisible = this.create('invisible', ['visible']);
      
      // this.disconnect('visible');
      // this.connect('visible', ['invisible']);
      

      Sortable.utils.on(this.invisible.el, 'start', event => {
        if(event.item.dataset.type == 'text') {
          console.log('start');
          this.disconnect('visible');
        }
      });

      Sortable.utils.on(this.invisible.el, 'end', event => {
        if(event.item.dataset.type == 'text') {
          console.log('end');
          this.connect('visible', ['invisible']);
        }
      });

      // Sortable.utils.on(this.invisible.el, 'move', event => {
      //   if(event.dragged.dataset.type == 'text') {
      //     console.log('move');
      //     return false;
      //   }
      //   return false;
      // });

      console.log(this);
    }

    create(name, put) {
      var element = $('.modules-dropzone[data-entries="' + name + '"]', this.element);
      return Sortable.create(element.get(0), {
        forceFallback: true,
        group: {
          name: name,
          put: put
        },
        animation: this.animation
      });
    }

    disconnect(name) {
      this[name].option('group', {
        name: name
      });
    }

    connect(name, put) {
      this[name].option('group', {
        name: name,
        put: put
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
