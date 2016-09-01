import Sortable from 'sortablejs';
import Module from './module';

(function($) {

  class Modules {
    constructor(element) {
      this.element = $(element);
      this.animation = 0;
      this.containment = $('.main');
      this.options = this.element.data('options');
      this.wait = 0;

      if (this.element.hasClass('modules-readonly') || $('.modules-empty' ,this.elemnt).length) return;

      this.modules = this.options.modules.map(module => {
        return new Module(module);
      });

      this.invisible = this.create('invisible', ['visible']);
      this.visible = this.create('visible');

      this.modules.forEach(module => {
        return module.children = $(this.visible.el.children).filter(function() {
          return this.dataset.template == module.template;
        });
      });

      this.events();
    }

    create(name, put) {
      var element = $('.modules-dropzone[data-entries="' + name + '"]', this.element);
      return Sortable.create(element.get(0), {
        forceFallback: true,
        group: {
          name: name,
          put: put || [],
        },
        animation: this.animation,
        scroll: false,
        filter: '.modules-entry-button'
      });
    }

    disconnect(name) {
      this[name].option('group', {
        name: name
      });

      // return false;
    }

    connect(name, put) {
      this[name].option('group', {
        name: name,
        put: put
      });

      // return true;
    }

    events() {
      Sortable.utils.on(this.invisible.el, 'start', event => {
        var module = this.module(event.item.dataset.template);

        if (this.droppable() && module.droppable()) {
          this.connect('visible', ['invisible'])
        } else {
          this.disconnect('visible')
        }

        // clearTimeout(this.timeout);
      });

      // Sortable.utils.on(this.visible.el, 'start', event => {
      //   clearTimeout(this.timeout);
      // });

      Sortable.utils.on(this.visible.el, 'add', event => {
        this.sort(event.item.dataset.uid, event.newIndex);
      });

      Sortable.utils.on(this.visible.el, 'update', event => {
        this.sort(event.item.dataset.uid, event.newIndex);
      });

      Sortable.utils.on(this.visible.el, 'remove', event => {
        this.hide(event.item.dataset.uid);
      });
    }

    module(template) {
      return this.modules.find(module => {
        return module.template == template;
      });
    }

    droppable() {
      if (!this.options.limit) return true;
      return this.options.limit && this.options.limit > this.visible.el.children.length;
    }

    sort(id, to) {
      $.post(this.options.url, {action: 'sort', id: id, to: (to + 1)}, this.reload.bind(this));
    }

    hide(id) {
      // $.post(this.options.url, {action: 'hide', id: id}, this.debounce(this.reload, this.wait));
      $.post(this.options.url, {action: 'hide', id: id}, this.reload.bind(this));
    }

    // debounce(func, wait, immediate) {
    //   return () => {
    //     if (this.timeout) {
    //       clearTimeout(this.timeout);
    //     } else if (immediate) {
    //       func.call(this);
    //     }
    //
    //     this.timeout = setTimeout(() => {
    //       if (!immediate) {
    //         func.call(this);
    //       }
    //       this.timeout = null;
    //     }, wait);
    //   };
    // }

    reload() {
      this.invisible.option('disabled', true);
      this.visible.option('disabled', true);

      // console.log('reload');
      app.content.reload();
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
