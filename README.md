<h1 align="center">File Cache</h1>
<p align="center">PHP için basit dosya tipi cache paketi.</p>

## Kurulum

🛠️ Paketi composer ile projenize dahil edin;

```bash
composer require mlevent/file-cache
```

## Örnek Kullanım

```php
use Mlevent\FileCache\FileCache;

$cache = new FileCache;

$lastUpdatedTime = $cache->refreshIfExpired('lastUpdatedTime', function () {
    return date("H:i:s");
}, 30);

echo "Updated time {$lastUpdatedTime}";
```

## 📧İletişim

İletişim için ghergedan@gmail.com adresine e-posta gönderin.
