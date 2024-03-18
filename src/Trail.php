<?php

namespace Momentum\Trail;

use Tighten\Ziggy\Ziggy;

class Trail
{
    public static function getRoutes(): array
    {
        $data = (new Ziggy)
            ->filter(['*debugbar.*', '*ignition.*'], false)
            ->toArray();

        $data['wildcards'] = static::getWildcardRoutes($data);

        return $data;
    }

    protected static function getWildcardRoutes(array $data): array
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
}
