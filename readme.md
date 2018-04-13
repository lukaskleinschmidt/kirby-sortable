# Kirby Sortable
A toolkit for managing subpages in the content area.

![Preview](http://github.kleinschmidt.at/kirby-sortable/modules/preview.gif)


## Table of contents
1. [Features](#1-features)
2. [Installation](#2-installation)
3. [Blueprint](#3-blueprint)
4. [Permissions](#4-permissions)
5. [Customize](#4-customize)
6. [Known Bugs](#5-known-bugs)
7. [Donate](#6-donate)


## 1 Features
This project started as a simple field and has grown into a reliable and extendable plugin.
It includes the [`sortable`](#sortable), [`modules`](#modules), [`redirect`](#redirect) and [`options`](#options) field.
In addition to the four fields the plugin has its own [registry](#registry).

### Fields
#### `sortable`
The core field. It is the base for the `modules` field.  
Change appereance in the [blueprint](#3-blueprint) or [build your own field](#4-customize) based on this one.

#### `modules`
The `modules` field is an extended `sortable` field. Bundled with the [modules-plugin](https://github.com/getkirby-plugins/modules-plugin) it is a very powerful tool. You can find further informations [here](fields/modules).  
To disable the field add `c::get('sortable.field.modules', false);` to your `config.php`.

#### `redirect`
Redirect a user to the parent of the currently visited panel page. Useful for pages that act as a container. You can find further informations [here](fields/redirect).  
To disable the field add `c::get('sortable.field.redirect', false);` to your `config.php`.

#### `options`
This field is used internally by the `sortable` field for the copy and paste functionality.

### Registry
With the registry you are able to customize the visual appearance and modify or add custom functionality.
The registry makes it possible to register [layouts](#layout-1), [actions](#action), [variants](#variant-1) and [translations](#translation). Learn more about how to register components in the [customize](#4-customize) section.


## 2 Installation
There are several ways to install the plugin.  
Please make sure you meet the minimum requirements.

### Requirements
- PHP 5.4+
- [Kirby](https://getkirby.com/) 2.3+
- [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin) 1.3+  
when you want to use the `modules` field

### Git
To clone or add the plugin as a submodule you need to cd to the root directory of your Kirby installation and run one of the corresponding command:  
`$ git clone https://github.com/lukaskleinschmidt/kirby-sortable.git site/plugins/sortable`  
`$ git submodule add https://github.com/lukaskleinschmidt/kirby-sortable.git site/plugins/sortable`  

### Kirby CLI
If you're using the Kirby CLI, you need to cd to the root directory of your Kirby installation and run the following command: `kirby plugin:install lukaskleinschmidt/kirby-sortable`

### Download
You can download the latest version of the plugin [here](https://github.com/lukaskleinschmidt/kirby-sortable/releases/latest).  
To install the plugin, please put it in the `site/plugins` directory.  
The plugin folder must be named `sortable`.

```
site/plugins/
    sortable/
        sortable.php
        ...
```


## 3 Blueprint
After installing the plugin you can use the new field types.
This blueprint shows all available options of the `sortable` field.

```yml
fields:
  title:
    label: Title
    type:  text

  sortable:
    label: Sortable
    type:  sortable

    sortable: true

    layout:  base
    variant: null

    limit: false

    parent: null
    prefix: null

    options:
      limit: false
```

### Options

#### `sortable`
Disable sorting when necessary.

#### `layout`
Load a registerd layout. The layout defines how a entry is rendered. Learn how to [register your own layout](#layout-1).

#### `variant`
Load a registerd variant. A variant is used to change the naming of the field from page to modules for example. Learn how to [register your own variant](#variant-1).

#### `limit`
Limit he number of visible pages. Example blueprint from the `modules` field.
```yml
fields:
  modules:
    label: Modules
    type:  modules

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
```yml
# home.yml

fields:
  events:
    label: Events
    type:  sortable

    parent: events
```
```
site/content/
    home/
        home.txt
        events/
            event-1/
                event.txt
            event-2/
                event.txt
        ...
```

#### `prefix`
Template prefix to filter available subpages.
```yml
# home.yml

fields:
  events:
    label: Events
    type:  sortable

    prefix: event.
```
```
site/content/
    home/
        home.txt
        event-1/
            event.default.txt
        event-2/
            event.default.txt
        subpage/
            default.txt
        ...
```

## 4 Permissions
Since `v2.4.0` you can now disable sorting independently from the `panel.page.visibility` permission. The new `panel.page.sort` permission will disable sorting as soon as one module denies sorting.

Keep in mind that the `panel.page.visibility` permission will additionally to disabling the visibility toggle still disable sorting also.

## 5 Customize
With the registry you are able to customize the visual appearance and modify or add functionality.
The registry makes it possible to register layouts, actions, variants and translations.

```php
// site/plugins/sortable-variants/sortable-variants.php

// Make sure that the sortable plugin is loaded
$kirby->plugin('sortable');

if(!function_exists('sortable')) return;

$kirby->set('field', 'variants', __DIR__ . DS . 'field');

$sortable = sortable();
$sortable->set('layout',  'variant', __DIR__ . DS . 'layout');
$sortable->set('variant', 'variants', __DIR__ . DS . 'variant');
$sortable->set('action',  '_add', __DIR__ . DS . 'actions' . DS . '_add');
$sortable->set('action',  '_paste', __DIR__ . DS . 'actions' . DS . '_paste');
$sortable->set('action',  '_duplicate', __DIR__ . DS . 'actions' . DS . '_duplicate');
```

A plugin can take care of registering all kinds of extensions, which will then be available in the `sortable` field or any field based on that.

### List of registry extensions
These are all possible registry extensions you can register this way:

#### layout
```php
// The layout directory must exist and it must have a PHP file with the same name in it
sortable()->set('layout', 'mylayout', __DIR__ . DS . 'mylayout');
```
Have a look at the [base layout](sortable/layouts/base) or the [module layout](sortable/layouts/module).

#### action
```php
// The action directory must exist and it must have a PHP file with the same name in it
sortable()->set('action', 'myaction', __DIR__ . DS . 'myaction');
```
Have a look at the [actions](sortable/actions).

#### variant
```php
// The variant directory must exist and can have multiple tranlation files
sortable()->set('variant', 'myvariant', __DIR__ . DS . 'myvariant');
```
Have a look at the [modules variant](sortable/variants/modules) or the [sections variant](sortable/variants/sections).

#### translation
```php
// The translation file must exist at the given location
sortable()->set('translation', 'en', __DIR__ . DS . 'en.php');
sortable()->set('translation', 'sv_SE', __DIR__ . DS . 'sv_SE.php');
```
Have a look at the [translations](sortable/translations).

### Examples
- [kirby-sortable-variants](https://github.com/lukaskleinschmidt/kirby-sortable-variants)
- [kirby-sortable-events](https://github.com/lukaskleinschmidt/kirby-sortable-events)


## 6 Known Bugs

Long title can cause the entries to overflow the content area.

- https://github.com/lukaskleinschmidt/kirby-sortable/issues/37
- https://github.com/getkirby/panel/pull/986

Put the following code in your custom [panel css](https://getkirby.com/docs/developer-guide/panel/css).

```css
.form-blueprint-checklist > fieldset {
  min-width: 0;
}

@-moz-document url-prefix() {
  .form-blueprint-checklist > fieldset {
    display: table-cell;
  }
}
```

---

Readonly has no effect.

- https://github.com/lukaskleinschmidt/kirby-sortable/issues/35

One simple and fast way is to disable functionality with some custom [panel css](https://getkirby.com/docs/developer-guide/panel/css).

```css
/* disable global actions */
.field-is-readonly .sortable__action,
.field-is-readonly .sortable__action .icon {
  pointer-events: none;
  color: #c9c9c9;
}

/* disable sorting */
.field-is-readonly .sortable [data-handle] {
  pointer-events: none;
  color: #c9c9c9;
}

/*
 * enable entry actions
 * only necessary when you want to disable
 * sorting but still want the actions to work
 */
.field-is-readonly .sortable-layout__action {
  pointer-events: auto;
}

/* disable entry actions */
.field-is-readonly .sortable-layout__action {
  pointer-events: none;
  color: #c9c9c9;
}
```

## 7 Donate

If you enjoy this plugin and want to support me you can [buy me a beer](https://www.paypal.me/lukaskleinschmidt/5eur) :)
