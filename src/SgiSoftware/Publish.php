<?php

namespace SgiSoftware;

class Publish
{
    public static function config()
    {
        $source = __DIR__ . '/config/api-config.php';
        $destination = dirname(__FILE__) . '/config/api-config.php';

        echo $source;
        echo $destination;

        if (!file_exists($destination)) {
            copy($source, $destination);
        }
    }
}
