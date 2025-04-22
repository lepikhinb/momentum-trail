<?php

use Illuminate\Support\Facades\Blade;
use Momentum\Trail\TrailBladeGenerator;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsString;

test('blade directive can be rendered', function () {
    $html = Blade::compileString('@trail');

    assertEquals("<?php echo app('" . TrailBladeGenerator::class . "')::generate(); ?>", $html);
})->only();

test('blade generator returns trail function', function () {
    $html = TrailBladeGenerator::generate();

    assertStringContainsString('window.trail', $html);
})->only();
