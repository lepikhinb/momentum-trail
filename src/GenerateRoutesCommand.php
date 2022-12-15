<?php

namespace Momentum\Trail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Tightenco\Ziggy\Ziggy;

class GenerateRoutesCommand extends Command
{
    protected $signature = 'trail:generate {--publish : Whether the command should publish the TypeScript helper}';

    protected $description = 'Generate route definitions for the frontend helper';

    protected string $path;

    public function handle()
    {
        $definition = $this->getRoutes();

        $total = count($definition['routes']);

        $this->prepareDirectory();

        $this->storeRoutes($definition);

        if ($this->option('publish')) {
            $this->publishHelper();

            $this->info('Published the TypeScript helper');
        }

        $this->table(
            ['Name', 'URI'],
            collect($definition['routes'] + $definition['wildcards'])
                ->map(fn (array $route, string $name) => [$name, $route['uri'] ?? ''])
        );

        $this->info("Extracted {$total} Laravel routes");

        return static::SUCCESS;
    }

    protected function getRoutes(): array
    {
        $data = (new Ziggy)
            ->filter(['*debugbar.*', '*ignition.*'], false)
            ->toArray();

        $data['wildcards'] = $this->getWildcardRoutes($data);

        return $data;
    }

    protected function getWildcardRoutes(array $data): array
    {
        $wildcards = [];

        foreach (array_keys($data['routes']) as $routeName) {
            $parts = explode('.', $routeName);

            array_pop($parts);

            $partial = '';

            foreach ($parts as $part) {
                $partial .= $part . '.';

                $wildcards[$partial . '*'] = [];
            }
        }

        return $wildcards;
    }

    protected function resolveOutputPath(): string
    {
        return config('trail.path');
    }

    protected function prepareDirectory(): void
    {
        if (! File::exists($this->resolveOutputPath())) {
            File::makeDirectory($this->resolveOutputPath());
        }
    }

    protected function storeRoutes(array $definition): void
    {
        File::put(
            $this->resolveOutputPath() . '/routes.json',
            json_encode($definition),
        );
    }

    protected function publishHelper(): void
    {
        File::copy(
            __DIR__ . '/../stubs/index.ts',
            $this->resolveOutputPath() . '/index.ts'
        );
    }
}
