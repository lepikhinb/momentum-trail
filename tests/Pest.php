<?php

declare(strict_types=1);

uses(Momentum\Trail\Tests\TestCase::class)->in('Pest');

function sanitize()
{
    unlink(config('trail.path') . '/index.ts');
    unlink(config('trail.path') . '/routes.json');
    rmdir(config('trail.path'));
}
