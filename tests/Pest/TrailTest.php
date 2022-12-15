<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertFileExists;

beforeEach(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', fn () => false)->name('settings.show');
        Route::put('/', fn () => false)->name('settings.update');
        Route::get('security', fn () => false)->name('security.show');
        Route::put('security', fn () => false)->name('security.update');
    });
});

test('the command produces output files', function () {
    artisan('trail:generate')->assertSuccessful();

    assertFileExists(config('trail.path') . '/index.ts');
    assertFileExists(config('trail.path') . '/routes.json');

    sanitize();
});

test('the command generates a list of defined routes', function () {
    artisan('trail:generate')->assertSuccessful();

    $definition = json_decode(file_get_contents(config('trail.path') . '/routes.json'), true);

    $routes = [
        'profile.settings.show',
        'profile.settings.update',
        'profile.security.show',
        'profile.security.update',
    ];

    foreach ($routes as $route) {
        assertArrayHasKey($route, $definition['routes']);
    }

    sanitize();
});

test('the command generates a list of wildcard routes', function () {
    artisan('trail:generate')->assertSuccessful();

    $definition = json_decode(file_get_contents(config('trail.path') . '/routes.json'), true);

    $wildcards = [
        'profile.*',
        'profile.settings.*',
        'profile.security.*',
    ];

    foreach ($wildcards as $wildcard) {
        assertArrayHasKey($wildcard, $definition['wildcards']);
    }

    sanitize();
});
