export default class Selection {
  constructor() {
    this.collection = {};
    this.selection = [];
    this.events = {};
    this.class = 'is-selected';
  }

  set(collection) {
    this.collection = collection;
  }

  index(uri) {
    return this.selection.indexOf(uri);
  }

  add(element, reset = false) {
    var uri = element.data('uri');
    if (reset) this.reset();
    if (this.index(uri) === -1) {
      element.addClass(this.class);
      this.selection.push(uri);
      this.trigger('change', this.selection);
    }
  }

  remove(element) {
    var index = this.index(element.data('uri'));
    if (index !== -1) {
      element.removeClass(this.class);
      this.selection.splice(index, 1);
      this.trigger('change', this.selection);
    }
  }

  toggle(element, reset = false) {
    if (this.index(element.data('uri')) === -1) {
      this.add(element, reset);
    } else {
      this.remove(element);
    }
  }

  get() {
    var selection = [];
    this.collection.each((index, element) => {
      var uri = $(element).data('uri');
      if (this.index(uri) !== -1)
        selection.push(uri);
    });
    return selection;
  }

  recall() {
    if (this.selection.length) {
      this.collection.filter((index, element) => {
        return this.index($(element).data('uri')) !== -1;
      }).addClass(this.class);
    }
  }

  reset() {
    this.collection.removeClass(this.class);
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
