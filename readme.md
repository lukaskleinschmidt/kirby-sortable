# Kirby Modules Field

This field is build on top of [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin). It provides a subpage like drag and drop for modules.

## Preview
![Preview](preview.gif)

## Installation
To install the field, please put it in the `site/fields` directory.

## Blueprints
After installing the custom form field, you can use the new `type` field `modules`.
```
fields:
    title:
        label: Title
        type: text
    modules:
        label: Modules
        type: modules
```
### Options:
Display a preview of the module.
```
modules:
    label: Modules
    type: modules
    style: preview
```
The template for this preview must be located inside the modules folder `site/modules/gallery/` and must be named `gallery.preview.php`. The `$module` object is available in the template.
```
site/
    modules/
        gallery/
            gallery.preview.php
            …
```

Do not redirect to the new module after creating one.
```
modules:
    label: Modules
    type: modules
    redirect: false
```