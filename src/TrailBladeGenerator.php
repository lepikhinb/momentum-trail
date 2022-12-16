<?php

namespace Momentum\Trail;

class TrailBladeGenerator
{
    public static function generate(): string
    {
        $routes = json_encode(Trail::getRoutes());

        return <<<HTML
        <script type="text/javascript">
            (function () {
                window.trail = {$routes};
            })();
        </script>
        HTML;
    }
}
