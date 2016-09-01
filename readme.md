# Kirby Modules Field

This field is build on top of [Kirby Modules Plugin](https://github.com/getkirby-plugins/modules-plugin). It provides a subpage like drag and drop for modules.

![Preview](preview.gif)

## Installation
To install the field, please put it in the `site/fields` directory.

## Blueprints
After installing the custom form field, you can use the new `type` field `modules`.
```yml
fields:
  title:
    label: Title
    type: text
  modules:
    label: Modules
    type: modules
```

### Options
```yml
label: Modules
type: modules
style: table
options:
  redirect: false
  preview: true
  delete: true
  limit: null
  edit: true
```

Option|Default|Description
---|---|---
`style`|`item`|Available styles are `item` and `table`.
`redirect`|`false`|Determine if the user should get redirected after adding a new module.
`preview`|`true`|The template for this preview must be located inside the modules folder `site/modules/gallery/` and must be named `gallery.preview.php`. The `$module` object is available in the template.
`delete`|`true`|Hide or show the delete button.
`limit`|`null`|Limit how many modules with the same template can be visible.
`edit`|`true`|Hide or show the edit button.

### Template specific options

You can override the default options by adding template specific options.

```yml
label: Modules
type: modules
style: table
options:
  redirect: false
  preview: true
  delete: true
  limit: null
  edit: true

  module.text:
    redirect: true
    preview: false

  module.gallery:
    limit: 1
    edit: false
```
