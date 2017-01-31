# Kirby Redirect Field

This field redirects a user to the parent of the currently visited panel page.  
Useful for pages that act like a container.

## Blueprint
```yml
fields:
  title:
    label: Title
    type: text

  redirect:
    label: Redirect
    type: redirect
  ...
```

## Redirect to a specific page

Redirect to `panel/projects/project-a/edit`.
When the page is not found you will get redirected to the dashboard.

```yml
  redirect:
    label: Redirect
    type: redirect

    redirect: projects/project-a
```

## Hide pages
There are several ways to hide pages in the panel. The easyiest way would be to set `hide: true` in the pages [blueprint](https://getkirby.com/docs/panel/blueprints/page-settings#hide-page). This would hide a page in the sidebar. To get rid of the breadcrumb link you can put something like this to your [custom panel css](https://getkirby.com/docs/developer-guide/panel/css).

```css
.breadcrumb-link[title="your-page-title"] {
  display: none;
}
```
