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

$updatedTime = $cache->refreshIfExpired('updatedTime', function () {
    return date("H:i:s");
});

echo "Updated time: {$updatedTime}";
```

Önbellek dosyaları varsayılan olarak ./cache dizininde saklanır.

```
$ tree ./cache
./cache
└── f7
    └── d1
        └── 7411a1eeb3dabcc2311f04eeb5371f0f40f192f3.cache
```

## 📧İletişim

İletişim için ghergedan@gmail.com adresine e-posta gönderin.
