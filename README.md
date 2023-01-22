# Momentum Trail

Momentum Trail is a Laravel package that provides a TypeScript `route()` helper function that works like Laravel's, making it easy to use your Laravel named routes in TypeScript with auto-completion and type-safety.

The package is built on top of [Ziggy](https://github.com/tighten/ziggy).

- [**Installation**](#installation)
  - [**Laravel**](#laravel)
  - [**Frontend**](#frontend)
- [**Usage**](#usage)
- [**Auto-generation**](#auto-generation)
- [**Advanced Inertia**](#advanced-inertia)
- [**Momentum**](#momentum)

## Installation

### Laravel
Install the package using `composer`.

```bash
composer require based/momentum-trail
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=trail-config
```

This is the contents of the published config file:

```php
return [
    'output' => [
        'routes' => resource_path('scripts/routes/routes.json'),
        'typescript' => resource_path('scripts/types/routes.d.ts'),
    ],
];
```

Set the paths according to your directory structure. You can set the `routes` path to `null` in case you plan to use the `Blade` directive instead of importing JSON.

### Frontend

Install the [frontend package](https://github.com/lepikhinb/momentum-trail-helper).

```bash
npm i momentum-trail
# or
yarn add momentum-trail
```

## Usage

Run the following command to generate TypeScript declarations and make your routes available on the frontend.

```php
php artisan trail:generate
```

Register your routes on the frontend. You can either import the generated JSON definition and pass it to the `defineRoutes` method within the entry point (`app.ts`) or use the `@trail` Blade directive to register routes in the `window` object and make them available globally.

```ts
import { defineRoutes } from "momentum-trail"
import routes from "./routes.json"

defineRoutes(routes)
```

### Vue 3
Alternatively, you can register routes using a Vue 3 plugin.

```ts
import { trail } from "momentum-trail"
import routes from "./routes.json"

createInertiaApp({
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .use(trail, { routes })
  }
})
```

####  Server-side rendering

The SSR engine *doesn't know* the current URL you are requesting.

To make the method `current` work correctly on the initial page load, you must pass the initial URL to the options list.

```ts
createServer((page: Page) =>
  createInertiaApp({
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(trail, {
          routes,
          url: props.initialPage.url
        })
    },
  })
)
```

### Blade
Optionally, add the `@trail` Blade directive to your main layout (before your application's JavaScript).

> By default, the output of the @trail Blade directive includes a list of all your application's routes and their parameters. This route list is included in the HTML of the page and can be viewed by end users.

```html
<html>
<head>
  @trail
</head>
</html>
```

Import the helper in your `.vue` files and enjoy perfect autocompletion and type-safety for both `route` and `current` methods.

```vue
<script lang="ts" setup>
import { route, current } from "momentum-trail"

const submit = () => form.put(route("profile.settings.update"))
</script>

<template>
  <a
    :class="[current('users.*') ? 'text-black' : 'text-gray-600']"
    :href="route('users.index')">
    Users
  </a>
</template>
```

The `route` helper function works like Laravel's — you can pass it the name of one of your routes, and the parameters you want to pass to the route, and it will return a URL.

```ts
// Generate a URL
route("jobs.index")
route("jobs.show", 1)
route("jobs.show", [1])
route("jobs.show", { job: 1 })

// Check the current route
current("jobs.*")
current("jobs.show")
current("jobs.show", 1)
```

For the complete documentation please refer to [Ziggy](https://github.com/tighten/ziggy#usage).

### Auto-generation

The package works best with [vite-plugin-watch](https://github.com/lepikhinb/vite-plugin-watch) plugin. You can set up the watcher to run the command on every file change.

```js
import { defineConfig } from "vite"
import { watch } from "vite-plugin-watch"

export default defineConfig({
    watch({
      pattern: "routes/*.php",
      command: "php artisan trail:generate",
    }),
  ],
})
```

## Advanced Inertia

[<img src="https://advanced-inertia.com/og.png" width="420px" />](https://advanced-inertia.com)

Take your Inertia.js skills to the next level with my book [Advanced Inertia](https://advanced-inertia.com/).
Learn advanced concepts and make apps with Laravel and Inertia.js a breeze to build and maintain.

## Momentum

Momentum is a set of packages designed to improve your experience building Inertia-powered apps.

- [Modal](https://github.com/lepikhinb/momentum-modal) — Build dynamic modal dialogs for Inertia apps
- [Preflight](https://github.com/lepikhinb/momentum-preflight) — Realtime backend-driven validation for Inertia apps
- [Paginator](https://github.com/lepikhinb/momentum-paginator) — Headless wrapper around Laravel Pagination
- [Trail](https://github.com/lepikhinb/momentum-trail) — Frontend package to use Laravel routes with Inertia
- [Lock](https://github.com/lepikhinb/momentum-lock) — Frontend package to use Laravel permissions with Inertia
- [Layout](https://github.com/lepikhinb/momentum-layout) — Persistent layouts for Vue 3 apps
- [Vite Plugin Watch](https://github.com/lepikhinb/vite-plugin-watch) — Vite plugin to run shell commands on file changes

## Credits

- [Boris Lepikhin](https://twitter.com/lepikhinb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
