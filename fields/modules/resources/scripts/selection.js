export default class Selection {
  constructor() {
    this.collection = {};
    this.selection = [];
    this.pointer = 0;
    this.events = {};
    this.options = {
      class: 'is-selected',
      data: 'uid',
    }
  }

  index(uid) {
    return this.selection.indexOf(uid);
  }

  add(element, reset = false, pointer = true) {
    if (reset) this.reset();
    if (pointer) this.pointer = this.collection.index(element);
    var uid = element.data(this.options.data);
    if (this.index(uid) === -1) {
      element.addClass(this.options.class);
      this.selection.push(uid);
      this.trigger('change', this.selection);
    }
  }

  remove(element) {
    var index = this.index(element.data(this.options.data));
    if (index !== -1) {
      element.removeClass(this.options.class);
      this.selection.splice(index, 1);
      this.trigger('change', this.selection);
    }
  }

  toggle(element, reset = false, pointer = true) {
    if (pointer) this.pointer = this.collection.index(element);
    if (this.index(element.data(this.options.data)) === -1) {
      this.add(element, reset, false);
    } else {
      this.remove(element);
    }
  }

  batch(element, reset = false) {
    if (reset) this.reset();
    var end = this.collection.index(element),
        start = this.pointer;
    if (start > end) {
      start = end;
      end = this.pointer;
    }
    var elements = this.collection.filter(index => {
      return index >= start && index <= end;
    });
    elements.each((index, element) => {
      this.add($(element), false, false);
    });
  }

  selected() {
    var selection = [];
    this.collection.each((index, element) => {
      var uid = $(element).data(this.options.data);
      if (this.index(uid) !== -1)
        selection.push(uid);
    });
    return selection;
  }

  recall() {
    if (this.selection.length) {
      this.collection.filter((index, element) => {
        return this.index($(element).data(this.options.data)) !== -1;
      }).addClass(this.options.class);
    }
  }

  reset() {
    this.collection.removeClass(this.options.class);
    this.selection = [];
  }

  // Little Dispatcher inspired by MicroEvent.js
  on(e, f) {
    this.events[e] = this.events[e] || [];
    this.events[e].push(f);
  }

  off(e, f) {
    if (e in this.events === false)
      return;

    this.events[e].splice(this.events[e].indexOf(f), 1);
  }

  trigger(e) {//e, ...args
    if (e in this.events === false)
      return;

    for (var i = 0; i < this.events[e].length; i++) {
      this.events[e][i].apply(this, Array.prototype.slice.call(arguments, 1));
    }
  }
}
