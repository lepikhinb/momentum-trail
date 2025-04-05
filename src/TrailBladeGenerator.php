<?php

namespace Momentum\Trail;

class TrailBladeGenerator
{
    public static function generate($group = null, $nonce = ''): string
    {
        $routes = json_encode(Trail::getRoutes($group));

        $nonce = $nonce ? ' nonce="' . $nonce . '"' : '';

        return <<<HTML
        <script type="text/javascript"$nonce>
            (function () {
                window.trail = $routes;
            })();
        </script>
        HTML;
    }
}
