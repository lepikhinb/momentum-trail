<?php

use Illuminate\Support\Facades\Blade;

use function PHPUnit\Framework\assertStringContainsString;

test('blade directive can be rendered', function () {
    $html = Blade::compileString('@trail');

    assertStringContainsString('window.trail', $html);
});
