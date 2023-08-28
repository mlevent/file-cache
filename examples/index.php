<?php declare(strict_types=1); error_reporting(E_ALL); require dirname(__DIR__).'/vendor/autoload.php';

use Mlevent\FileCache\FileCache;

$cache = new FileCache;

$lastUpdatedTime = $cache->refreshIfExpired('lastUpdatedTime', function () {
    return date("H:i:s");
}, 4);

echo "Updated time {$lastUpdatedTime}";

echo '<pre>';
print_r($cache->getCacheStore());
echo '</pre>';