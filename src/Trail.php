<?php

namespace Momentum\Trail;

use Tightenco\Ziggy\Ziggy;

class Trail
{
    public static function getRoutes($group = null): array
    {
        $data = (new Ziggy($group))
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
