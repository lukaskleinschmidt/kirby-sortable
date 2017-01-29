---

### Update from v2.1 to v2.2
You have to change the plugin folder form `modules-field` to `sortable`.  
The `modules-field` is still in here. So everything should work as before.

---

# Kirby Sortable Field
This field gives you the tools to easily manage subpages in the content area.  
The following gif shows the field in combination with the [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin).

![Preview](http://github.kleinschmidt.at/kirby-sortable/modules/preview.gif)

## What is on board?

Actually the plugin comes with four fields and a own [registry](#registry).  
A quick overview of the fields.

### sortable
The `sortable` field is the core field which is easy to extend an modify.

### modules
The `modules` field is a extended `sortable` field. Together with the [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin) it is a very powerful tool. You can find further informations [here](fields/modules/readme.md).  
To disable the field add `c::get('sortable.field.modules', false)` to your `config.php`.

### redirect
The `redirect` field redirects a user to the parent of the currently visited panel page. Helpfull for pages that act like a container. You can find further informations [here](fields/redirect/readme.md).  
To disable the field add `c::get('sortable.field.redirect', false)` to your `config.php`.

### options
The `options` field is just a helper that is used in some forms in the `sortable` field.



## Installation

To install the plugin, please put it in the `site/plugins` directory.  
The plugin folder must be named `sortable`.

```
site/plugins/
    sortable/
        sortable.php
        ...
```

If you are just here for the modules you can continue reading [here](fields/modules/readme.md).


### Download

You can download the latest version of the plugin from https://github.com/lukaskleinschmidt/kirby-sortable/releases/latest

### With Git

If you are familiar with Git, you can clone this repository from Github into your plugins folder.

```git clone https://github.com/lukaskleinschmidt/kirby-sortable.git sortable```


## Blueprint
After installing the plugin, you can use the new field type `sortable`.  
This blueprint shows all available options and their defaults.

```yml
fields:
  title:
    label: Title
    type: text

  sortable:
    label: Sortable
    type:  sortable

    layout:  base
    variant: base

    limit: false

    parent: null
    prefix: null

    options:
      limit: false
  ...
```

### layout
Load a registerd layout. The layout defines how a entry is rendered.

### variant
Load a registerd variant. A variant should be used when you want to change the naming of the field. If you do not want your product variants to be referred as pages in the panel for example. This is more for convinience or to reduce confusion for clients.

### limit
Limit he number of visible pages. It is also possible to add a limit for templates or a specific template.  
Example from the `modules` field.
```yml
  modules:
    label: Modules
    type: modules

    # Allow 3 visible modules overall
    limit: 3

    # Template specific option
    options:
      module.gallery:
        # Allow only 1 visible gallery module
        limit: 1
```

### parent
Uid to use when looking for the container page. If left empty the field will look for pages to display in the current page.

### prefix
Template prefix to filter available pages.

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

As you can see in this example of a product variant plugin, the plugin can take care of registering all kinds of extensions, which will then be available in the `sortable` field or any extension of the field.

### List of registry extensions
These are all possible registry extensions you can register this way:

#### layout
```php
// The layout directory must exist and it must have a PHP file with the same name in it
$kirby->set('layout', 'mylayout', __DIR__ . DS . 'mylayout');
```

#### action
```php
// The action directory must exist and it must have a PHP file with the same name in it
$kirby->set('action', 'myaction', __DIR__ . DS . 'myaction');
```

#### variant
```php
// The variant directory must exist and can have multiple tranlation files
$kirby->set('variant', 'myvariant', __DIR__ . DS . 'myvariant');
```
Example for a variant in english, german and swedish.
```
myvariant/
    en.php
    de.php
    sv_SE.php
    ...
```

#### translation
```php
// The translation file must exist at the given location
$kirby->set('translation', 'en', __DIR__ . DS . 'en.php');
$kirby->set('translation', 'sv_SE', __DIR__ . DS . 'sv_SE.php');
```
Please consider a PR if you add a language which is not yet in here.


## I want to extend the plugin but don't know how?
If you have som experience in custom form fields it should be a pretty steep learning curve. For references on how to do something please have a look at the [demo branch](https://github.com/lukaskleinschmidt/kirby-modules-field/tree/demo) or the way the `modules` field is build.  
The three components of the `modules` field:
- [field](fields/modules)
- [layout](sortable/layouts/module)
- [variant](sortable/variants/modules)


## Requirements
- [Kirby](https://getkirby.com/) 2.3+
- [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin) 1.3+  
when you want to use the `modules` field
