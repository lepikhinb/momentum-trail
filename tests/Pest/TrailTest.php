<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Momentum\Trail\Trail;
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
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', fn () => false)->name('index');
    });
});

test('trail generates a list of defined routes', function () {
    $definition = Trail::getRoutes();

    $routes = [
        'profile.settings.show',
        'profile.settings.update',
        'profile.security.show',
        'profile.security.update',
        'dashboard.index'
    ];

    expect($definition['routes'])
        ->toBeArray()
        ->toHaveKeys($routes);

})->only();

test('trail generates a list of defined routes in a group', function () {
    $definition = Trail::getRoutes('dashboard');

    $routes = [
        'dashboard.index'
    ];

    expect($definition['routes'])
        ->toBeArray()
        ->toHaveKeys($routes);
})->only();

test('trail generates a list of wildcard routes', function () {
    $definition = Trail::getRoutes();

    $wildcards = [
        'profile.*',
        'profile.settings.*',
        'profile.security.*',
        'dashboard.*'
    ];

    expect($definition['wildcards'])
        ->toBeArray()
        ->toHaveKeys($wildcards);
})->only();

test('the command produces output files', function () {
    artisan('trail:generate')->assertSuccessful();

    assertFileExists(config('trail.output.routes'));
    assertFileExists(config('trail.output.typescript'));

    $definition = json_decode(file_get_contents(config('trail.output.routes')), true);

    $routes = [
        'profile.settings.show',
        'profile.settings.update',
        'profile.security.show',
        'profile.security.update',
    ];

    foreach ($routes as $route) {
        assertArrayHasKey($route, $definition['routes']);
    }

    unlink(config('trail.output.routes'));
    unlink(config('trail.output.typescript'));
})->only();
