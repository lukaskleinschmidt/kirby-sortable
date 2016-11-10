export default class Selection {
  constructor() {
    this.collection = {};
    this.selection = [];
    this.class = 'is-selected';
  }

  set(collection) {
    this.collection = collection;
  }

  index(uri) {
    console.log(uri);
    return this.selection.indexOf(uri);
  }

  add(element, reset = false) {
    var uri = element.data('uri');
    if (reset) this.flush();
    if (this.index(uri) === -1) {
      element.addClass(this.class);
      this.selection.push(uri);
    }
  }

  remove(element) {
    var index = this.index(element.data('uri'));
    if (index !== -1) {
      element.removeClass(this.class);
      this.selection.splice(index, 1);
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
    return this.selection;
  }

  recall() {
    if (this.selection.length) {
      this.collection.filter((index, element) => {
        console.log(this.index($(element).data('uri')))
        return this.index($(element).data('uri')) !== -1;
      }).addClass(this.class);
    }
  }

  flush() {
    this.collection.removeClass(this.class);
    this.selection = [];
  }
}
