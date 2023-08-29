<?php declare(strict_types=1); error_reporting(E_ALL); require dirname(__DIR__).'/vendor/autoload.php';

use Mlevent\FileCache\FileCache;

$cache = new FileCache;

$updatedTime = $cache->refresh('updatedTime', function () {
    return date("H:i:s");
});

echo "Updated time: {$updatedTime}";

echo '<pre>';
print_r($cache->getStore());
echo '</pre>';