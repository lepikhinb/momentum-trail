<?php

namespace Momentum\Trail\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Momentum\Trail\Trail;

class GenerateRoutesCommand extends Command
{
    protected $signature = 'trail:generate';

    protected $description = 'Generate route definitions for the frontend helper';

    protected string $path;

    public function handle()
    {
        $routes = Trail::getRoutes();

        $total = count($routes['routes']);

        if (config('trail.output.routes')) {
            $this->storeRoutes($routes);
        }

        $this->storeTypeScript($routes);

        $this->table(
            ['Name', 'URI'],
            collect($routes['routes'] + $routes['wildcards'])
                ->map(fn (array $route, string $name) => [$name, $route['uri'] ?? ''])
        );

        $this->info("Extracted {$total} Laravel routes");

        return static::SUCCESS;
    }

    protected function storeRoutes(array $routes): void
    {
        File::put(
            config('trail.output.routes'),
            json_encode($routes)
        );
    }

    protected function storeTypeScript(array $routes): void
    {
        $definition = json_encode($routes);

        $output = <<<TYPESCRIPT
        import "momentum-trail"

        declare module "momentum-trail" {
            export interface RouterGlobal {$definition}
        }
        TYPESCRIPT;

        File::put(
            config('trail.output.typescript'),
            $output
        );
    }
}
