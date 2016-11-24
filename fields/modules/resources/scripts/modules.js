import Selection from './selection';

(function($) {

  var selection = new Selection();
  var shift = false;
  var strg = false;

  selection.on('change', selection => {
    console.log(selection);
  });

  class Modules {
    constructor(element) {
      this.element = $(element);
      this.modules = $('.module', element);

      this.options = {};
      this.options.api = this.element.data('api');
      this.options.copy = this.element.data('copy');

      console.log(this.options);

      // var id = this.element.attr('id');
      // if (!selection.id || selection.id == id) {
      //   selection.collection = this.modules;
      //   selection.id = id;
      //   selection.recall();
      // }

      selection.collection = this.modules;
      selection.recall();

      // if (this.element.hasClass('modules-readonly') || $('.modules-empty', this.element).length) return;

      this.element._sortable({
        handle: '.module__preview, .module__title',
        start: (event, ui) => {
          this.element._sortable('refreshPositions');
          selection.add($(ui.item), true);
          this.blur();
        },
      });

      this.events();
    }

    blur() {
      $('.form input:focus, .form select:focus, .form textarea:focus').blur();
      app.content.focus.forget();
    }

    events() {
      var self = this;

      this.element.on('_sortableupdate', (event, ui) => {
        var to = this.element.children().index(ui.item) + 1;
        var uid = ui.item.data('uid');
        this.disable();
        this.action([uid, to, 'sort'].join('/'));
      });

      this.element.on('click', '[data-action]', function(event) {
        var element = $(this);
        var action = element.data('action') || element.attr('href');
        $.post(action, self.reload.bind(self));
        return false;
      });

      this.modules.on('click', event => {
        // var id = this.element.attr('id');
        // if (selection.id !== id) {
        //   selection.reset();
        //   selection.collection = this.modules;
        //   selection.id = id;
        // }
        this.select($(event.delegateTarget));
      });

      $(document)
        .off('.modules')
        .on('keydown.modules', event => {
          switch (event.keyCode) {
            case 16:
              if (shift) return true;
              shift = true;
              break;
            case 17:
              if (strg) return true;
              strg = true;
              break;
            case 67:
              if (!event.metaKey && !event.ctrlKey) return true;
              var selected = selection.selected();
              if (selected.length) {
                this.action('copy', {
                  modules: selected
                });
              }
              break;
            case 86:
              if (!event.metaKey && !event.ctrlKey) return true;
              // console.log($.cookie('kirby_field_modules'));
              if (this.modules.hasClass('is-selected')) {
                app.modal.open(this.options.api + '/paste');
              }
              break;
          }
        })
        .on('keyup.modules', event => {
          switch (event.keyCode) {
            case 16:
              shift = false;
              break;
            case 17:
              strg = false;
              break;
          }
        })
        .on('click.modules', event => {
          if (!$(event.target).closest('.module').length) {
            selection.reset();
          }
        });
    }

    select(element) {
      this.blur();

      element = $(element);

      if (shift && strg) {
      } else if (shift) {
      } else if (strg) {
        selection.toggle(element);
      } else {
        selection.add(element, true);
      }
    }

    action(action, data = {}) {
      console.log(this.options.api + '/' + action, data);
      $.post(this.options.api + '/' + action, data, this.reload.bind(this));
    }

    disable() {
      this.element._sortable('disable');
    }

    reload() {
      this.disable();
      app.content.reload();
    }
  }

  // Fixing scrollbar jumping issue
  // http://stackoverflow.com/questions/1735372/jquery-sortable-list-scroll-bar-jumps-up-when-sorting
  $.widget('ui._sortable', $.ui.sortable, {
    _mouseStart: function(event, overrideHandle, noActivation) {
      var i, body,
        o = this.options;

      this.currentContainer = this;

      //We only need to call refreshPositions, because the refreshItems call has been moved to mouseCapture
      this.refreshPositions();

      //Create and append the visible helper
      this.helper = this._createHelper(event);

      //Cache the helper size
      this._cacheHelperProportions();

      /*
       * - Position generation -
       * This block generates everything position related - it's the core of draggables.
       */

      //Cache the margins of the original element
      this._cacheMargins();

      //Get the next scrolling parent
      this.scrollParent = this.helper.scrollParent();

      //The element's absolute position on the page minus margins
      this.offset = this.currentItem.offset();
      this.offset = {
        top: this.offset.top - this.margins.top,
        left: this.offset.left - this.margins.left
      };

      $.extend(this.offset, {
        click: { //Where the click happened, relative to the element
          left: event.pageX - this.offset.left,
          top: event.pageY - this.offset.top
        },
        parent: this._getParentOffset(),
        relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
      });

      //Create the placeholder
      this._createPlaceholder();

      // Only after we got the offset, we can change the helper's position to absolute
      // TODO: Still need to figure out a way to make relative sorting possible
      this.helper.css("position", "absolute");
      this.cssPosition = this.helper.css("position");

      //Generate the original position
      this.originalPosition = this._generatePosition(event);
      this.originalPageX = event.pageX;
      this.originalPageY = event.pageY;

      //Adjust the mouse offset relative to the helper if "cursorAt" is supplied
      (o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));

      //Cache the former DOM position
      this.domPosition = { prev: this.currentItem.prev()[0], parent: this.currentItem.parent()[0] };

      //If the helper is not the original, hide the original so it's not playing any role during the drag, won't cause anything bad this way
      if(this.helper[0] !== this.currentItem[0]) {
        this.currentItem.hide();
      }

      //Set a containment if given in the options
      if(o.containment) {
        this._setContainment();
      }

      if( o.cursor && o.cursor !== "auto" ) { // cursor option
        body = this.document.find( "body" );

        // support: IE
        this.storedCursor = body.css( "cursor" );
        body.css( "cursor", o.cursor );

        this.storedStylesheet = $( "<style>*{ cursor: "+o.cursor+" !important; }</style>" ).appendTo( body );
      }

      if(o.opacity) { // opacity option
        if (this.helper.css("opacity")) {
          this._storedOpacity = this.helper.css("opacity");
        }
        this.helper.css("opacity", o.opacity);
      }

      if(o.zIndex) { // zIndex option
        if (this.helper.css("zIndex")) {
          this._storedZIndex = this.helper.css("zIndex");
        }
        this.helper.css("zIndex", o.zIndex);
      }

      //Prepare scrolling
      if(this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {
        this.overflowOffset = this.scrollParent.offset();
      }

      //Call callbacks
      this._trigger("start", event, this._uiHash());

      //Recache the helper size
      if(!this._preserveHelperProportions) {
        this._cacheHelperProportions();
      }


      //Post "activate" events to possible containers
      if( !noActivation ) {
        for ( i = this.containers.length - 1; i >= 0; i-- ) {
          this.containers[ i ]._trigger( "activate", event, this._uiHash( this ) );
        }
      }

      //Prepare possible droppables
      if($.ui.ddmanager) {
        $.ui.ddmanager.current = this;
      }

      if ($.ui.ddmanager && !o.dropBehaviour) {
        $.ui.ddmanager.prepareOffsets(this, event);
      }

      this.dragging = true;

      this.helper.addClass("ui-sortable-helper");
      this._mouseDrag(event); //Execute the drag once - this causes the helper not to be visible before getting its correct position
      return true;
    }
  });

  $.fn.modules = function() {
    return this.each(function() {
      if ($(this).data('modules')) {
        return $(this);
      } else {
        var modules = new Modules(this);
        $(this).data('modules', modules);
        return $(this);
      }
    });
  }

})(jQuery);
