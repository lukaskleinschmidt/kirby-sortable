(function($) {

  var Sort = function(element) {
    var self = this;

    this.element = $(element);
    this.container = $('.sortable__container[data-sortable="true"]', element);
    this.api = this.element.data('api');

    this.container._sortable({
      handle: '[data-handle]',
      start: function(event, ui) {
        self.container._sortable('refreshPositions');
        self.blur();
      },
      update: function(event, ui) {
        var to = self.container.children().index(ui.item) + 1;
        var uid = ui.item.data('uid');
        var action = [self.api, uid, to, 'sort'].join('/');

        // disable sorting because a reload is expected
        self.disable();

        $.post(action, self.reload.bind(self));
      }
    });

    this.element.on('click', '[data-action]', function(event) {
      var element = $(this);
      var action = element.data('action') || element.attr('href');

      $.post(action, self.reload.bind(self));

      return false;
    });

    // setup extended field script
    var key = this.element.data('field-extended');
    if(key != 'sortable' && this.element[key]) this.element[key]();
  };

  Sort.prototype.blur = function() {
    $('.form input:focus, .form select:focus, .form textarea:focus').blur();
    app.content.focus.forget();
  };

  Sort.prototype.disable = function() {
    this.container._sortable('disable');
  };

  Sort.prototype.reload = function() {
    this.disable();
    app.content.reload();
  };


  // Fixing scrollbar jumping issue
  // http://stackoverflow.com/questions/1735372/jquery-sortable-list-scroll-bar-jumps-up-when-sorting
  if (typeof($.ui._sortable) === 'undefined') {
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
  }

  $.fn.sort = function() {
    return this.each(function() {
      if ($(this).data('sort')) {
        return $(this);
      } else {
        var sort = new Sort(this);
        $(this).data('sort', sort);
        return $(this);
      }
    });
  }

})(jQuery);
