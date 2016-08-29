export default class Module {
  constructor(module) {
    this.template = module.template;
    this.options = module.options;
  }

  droppable() {
    if (!this.options.limit) return true;
    return this.options.limit && this.options.limit > this.children.length;
  }
}
