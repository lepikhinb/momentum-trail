<?php

use Illuminate\Support\Facades\Blade;
use function PHPUnit\Framework\assertStringContainsString;

test('blade directive can be rendered', function () {
    $html = Blade::compileString('@trail');

    assertStringContainsString('<?php echo app("Momentum\Trail\TrailBladeGenerator")->generate(, ); ?>', $html);
});

test('blade directive can be rendered with group', function () {
    $html = Blade::compileString('@trail("admin")');

    assertStringContainsString('<?php echo app("Momentum\Trail\TrailBladeGenerator")->generate("admin", ); ?>', $html);
});

test('blade directive can be rendered with nonce', function () {
    $html = Blade::compileString('@trail("", "abc123")');

    assertStringContainsString('<?php echo app("Momentum\Trail\TrailBladeGenerator")->generate("", "abc123", ); ?>', $html);
});