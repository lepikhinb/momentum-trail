# Momentum Trail

Momentum Trail is an **opinionated** Laravel package that provides a TypeScript `route()` helper function that works like Laravel's, making it easy to use your Laravel named routes in TypeScript with auto-completion and type-safety.

## Installation

Install the package using `composer`.

```bash
composer require based/momentum-trail
```

The package is built on top of [Ziggy](https://github.com/tighten/ziggy). Since the TypeScript helper relies on generated JSON and is not published as a dedicated `npm` package, you may need to install `Ziggy` manually.

```bash
npm install ziggy-js
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=trail-config
```

This is the contents of the published config file:

```php
return [
    'path' => resource_path('scripts/utils/route'),
];

```

Set the `path` according to your directory structure (`js/route`). Please make sure to specify a dedicated directory for helpers.

## Usage

Run the following command to publish the TypeScript helper and make your routes available on the frontend.

```php
php artisan trail:generate --publish
```

Import the published helper in your `.ts`/`.vue`/`.tsx` files and enjoy perfect autocompletion and type-safety for both `route` and `current` methods.

```vue
<script lang="ts" setup>
import { route, current } from "@/scripts/utils/route"

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

The package works best with [vite-plugin-watch](https://github.com/lepikhinb/momentum-paginator) plugin. You can set up the watcher to run the command on every file change.

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

[<img src="https://advanced-inertia.com/og5.png" width="420px" />](https://advanced-inertia.com)

Make Inertia-powered frontend a breeze to build and maintain with my upcoming book [Advanced Inertia](https://advanced-inertia.com/). Join the waitlist and get **20% off** when the book is out.

## Momentum

Momentum is a set of packages designed to bring back the feeling of working on a single codebase to Inertia-powered apps.

- [Modal](https://github.com/lepikhinb/momentum-modal) — Build dynamic modal dialogs for Inertia apps
- [Preflight](https://github.com/lepikhinb/momentum-preflight) — Realtime backend-driven validation for Inertia apps
- [Paginator](https://github.com/lepikhinb/momentum-paginator) — Headless wrapper around Laravel Pagination
- [Trail](https://github.com/lepikhinb/momentum-trail) — Frontend package to use Laravel routes with Inertia
- [Lock](https://github.com/lepikhinb/momentum-lock) — Frontend package to use Laravel permissions with Inertia _(coming soon)_
- [Vite Plugin Watch](https://github.com/lepikhinb/vite-plugin-watch) — Vite plugin to run shell commands on file changes

## Credits

- [Boris Lepikhin](https://twitter.com/lepikhinb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.