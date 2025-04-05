<?php

use Momentum\Trail\TrailBladeGenerator;

test('Generate script tag with routes', function () {
    $html = TrailBladeGenerator::generate();

    expect($html)
        ->toBeString()
        ->toContain('<script type="text/javascript">')
        ->toContain('window.trail = {');
});

test('Generates script tag with nonce', function () {
    $html = TrailBladeGenerator::generate(null, 'abc123');

    expect($html)
        ->toBeString()
        ->toContain('<script type="text/javascript" nonce="abc123">')
        ->toContain('window.trail = {');
});