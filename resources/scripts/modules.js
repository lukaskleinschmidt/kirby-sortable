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

      this.visible = $('.modules-dropzone[data-entries="visible"]', this.element);
      this.invisible = $('.modules-dropzone[data-entries="invisible"]', this.element);

      this.create(this.visible, this.invisible);
      this.create(this.invisible);

      this.modules.forEach(module => {
        return module.children = this.visible.children().filter(function() {
          return this.dataset.template == module.template;
        });
      });

      this.events();
    }

    create(element, connectWith) {
      element._sortable({
        connectWith: connectWith || false,
        start: () => {
          element._sortable('refreshPositions');
        },
      });
    }

    disconnect(element) {
      element._sortable('option', 'connectWith', false);
      element._sortable('refresh');
    }

    connect(element, connectWith) {
      element._sortable('option', 'connectWith', connectWith);
      element._sortable('refresh');
    }

    disable() {
      this.invisible._sortable('disable');
      this.visible._sortable('disable');
    }

    events() {
      this.invisible.on('_sortablestart', (event, ui) => {
        var module = this.module(ui.item.data('template'));

        if (this.droppable() && module.droppable()) {
          this.connect(this.invisible, this.visible)
        } else {
          this.disconnect(this.invisible)
        }
      });


      this.visible.on('_sortablereceive', (event, ui) => {
        this.sort(ui.item.data('uid'), ui.item.index());
      });

      this.visible.on('_sortablestop', (event, ui) => {
        if (ui.item.parent().data('entries') == 'visible') {
          this.sort(ui.item.data('uid'), ui.item.index());
        }
      });

      this.visible.on('_sortableremove', (event, ui) => {
        this.hide(ui.item.data('uid'));
      });
    }

    module(template) {
      return this.modules.find(module => {
        return module.template == template;
      });
    }

    droppable() {
      if (!this.options.limit) return true;
      return this.options.limit && this.options.limit > this.visible.children().length;
    }

    sort(id, to) {
      this.disable();
      $.post(this.options.url, {action: 'sort', id: id, to: (to + 1)}, this.reload.bind(this));
    }

    hide(id) {
      $.post(this.options.url, {action: 'hide', id: id}, this.reload.bind(this));
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
