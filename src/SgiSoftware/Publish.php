<?php

namespace SgiSoftware;

class Publish
{
    public static function config()
    {
        $source = __DIR__ . '/../config/api-config.php';
        $destination = __DIR__ . '/../../../config/api-config.php';

        if (!file_exists($destination)) {
            copy($source, $destination);
        }
    }
}
