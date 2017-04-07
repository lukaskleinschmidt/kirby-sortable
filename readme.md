---

### Help keeping me motivated :)
If you enjoy this plugin and want to support me you can buy me a beer.

[![Buy me a beer](http://github.kleinschmidt.at/kirby-sortable/buy-me-a-beer-v1.png)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F6SAVYV7PKTHA)

---

# Kirby Sortable Field
Manage subpages in the content area.  
This plugin includes the [`sortable`](#sortable), [`modules`](#modules) and [`redirect`](#redirect) field.
The following animation shows the [`modules`](#modules) field in combination with the [modules-plugin](https://github.com/getkirby-plugins/modules-plugin).

![Preview](http://github.kleinschmidt.at/kirby-sortable/modules/preview.gif)

## Scope of the plugin
In addition to the three fields the plugin has its own [registry](#registry).
A short overview of the fields.

### `sortable`
The core field. It is the base for the `modules` field.  
Change appereance in the [blueprint](#blueprint) or [build your own field](#extend-the-sortable-field) based on this one.

### `modules`
The `modules` field is an extended `sortable` field. Bundled with the [modules-plugin](https://github.com/getkirby-plugins/modules-plugin) it is a very powerful tool. You can find further informations [here](fields/modules/readme.md).

To disable the field add `c::get('sortable.field.modules', false);` to your `config.php`.

### `redirect`
Redirect a user to the parent of the currently visited panel page. Useful for pages that act as a container. You can find further informations [here](fields/redirect/readme.md).

To disable the field add `c::get('sortable.field.redirect', false);` to your `config.php`.

## Installation
To install the plugin, please put it in the `site/plugins` directory.  
The plugin folder must be named `sortable`.

```
site/plugins/
    sortable/
        sortable.php
        ...
```

### Download
You can download the latest version of the plugin from https://github.com/lukaskleinschmidt/kirby-sortable/releases/latest

### With Git
If you are familiar with Git, you can clone this repository from Github into your plugins folder.

```git clone https://github.com/lukaskleinschmidt/kirby-sortable.git sortable```

## Blueprint
After installing the plugin you can use the new field types.
This blueprint shows all available options of the `sortable` field.

```yml
fields:
  title:
    label: Title
    type: text

  sortable:
    label: Sortable
    type:  sortable

    layout:  base
    variant: null

    limit: false

    parent: null
    prefix: null

    options:
      limit: false
  ...
```

#### `layout`
Load a registerd layout. The layout defines how a entry is rendered. Learn how to [register your own layout](#layout-1).

#### `variant`
Load a registerd variant. A variant is used to change the naming of the field from page to modules for example. Learn how to [register your own variant](#variant-1).

#### `limit`
Limit he number of visible pages. Example blueprint from the `modules` field.
```yml
  modules:
    label: Modules
    type: modules

    # Allow 5 visible modules overall
    limit: 5

    # Template specific option
    options:

      # Allow only 3 modules per template (applies to all templates)
      limit: 3
      module.gallery:

        # Allow only 1 visible gallery module (overwrites the current limit of 3)
        limit: 1
```

#### `parent`
Uid to use when looking for the container page. If left empty the field will look for subpages in the current page.

#### `prefix`
Template prefix to filter available subpages.

## Registry
With the new registry you are now able to customize the visual appearance and modify or add custom functionality.
The registry makes it possible to register layouts, actions, variants and translations.

```php
// site/plugins/product-variants/product-variants.php

// Make sure that the sortable plugin is loaded
$kirby->plugin('sortable');

if(!function_exists('sortable')) return;

$kirby->set('field', 'variants', __DIR__ . DS . 'fields' . DS . 'variants');

$sortable = sortable();
$sortable->set('action', 'stock', __DIR__ . DS . 'actions' . DS . 'stock');
$sortable->set('layout', 'variant', __DIR__ . DS . 'layouts' . DS . 'variant');
$sortable->set('variant', 'variants', __DIR__ . DS . 'variants' . DS . 'variants');
```

As you can see in this example of a product variant field, the plugin can take care of registering all kinds of extensions, which will then be available in the `sortable` field or any field based on that.

### List of registry extensions
These are all possible registry extensions you can register this way:

#### `layout`
```php
// The layout directory must exist and it must have a PHP file with the same name in it
sortable()->set('layout', 'mylayout', __DIR__ . DS . 'mylayout');
```
Have a look at the [base layout](sortable/layouts/base) or the [module layout](sortable/layouts/module).

#### `action`
```php
// The action directory must exist and it must have a PHP file with the same name in it
sortable()->set('action', 'myaction', __DIR__ . DS . 'myaction');
```
Have a look at the available [actions](sortable/actions).

#### `variant`
```php
// The variant directory must exist and can have multiple tranlation files
sortable()->set('variant', 'myvariant', __DIR__ . DS . 'myvariant');
```
Have a look at the [modules variant](sortable/variants/modules) or the [sections variant](sortable/variants/sections).

#### `translation`
```php
// The translation file must exist at the given location
sortable()->set('translation', 'en', __DIR__ . DS . 'en.php');
sortable()->set('translation', 'sv_SE', __DIR__ . DS . 'sv_SE.php');
```
Have a look at the available [translations](sortable/translations).

## Extend the sortable field
Currently you can have a look at the `modules` field within this plugin. Since the field is included in the plugin all parts are registered within the plugin.

- [fields/modules](fields/modules)
- [layouts/module](sortable/layouts/module)
- [variants/module](sortable/variants/modules)

Also check out the [demo](https://github.com/lukaskleinschmidt/kirby-modules-field/tree/demo) branch. I will try to update the demo with a more meaningful example soon.


## Requirements
- PHP 5.4+
- [Kirby](https://getkirby.com/) 2.3+
- [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin) 1.3+  
when you want to use the `modules` field
