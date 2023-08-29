<h1 align="center">🗳️ file-cache</h1>
<p align="center">PHP için basit, dosya tipi önbellek sınıfı.</p>
<p align="center">
<img src="https://img.shields.io/packagist/dependency-v/mlevent/file-cache/php?style=plastic"/>
<img src="https://img.shields.io/packagist/v/mlevent/file-cache?style=plastic"/>
<img src="https://img.shields.io/github/last-commit/mlevent/file-cache?style=plastic"/>
<img src="https://img.shields.io/github/issues/mlevent/file-cache?style=plastic"/>
<img src="https://img.shields.io/packagist/dt/mlevent/file-cache?style=plastic"/>
<img src="https://img.shields.io/github/stars/mlevent/file-cache?style=plastic"/>
<img src="https://img.shields.io/github/forks/mlevent/file-cache?style=plastic"/>
</p>

## Kurulum

🛠️ Paketi composer ile projenize dahil edin;

```bash
composer require mlevent/file-cache
```

## Örnek Kullanım

```php
use Mlevent\FileCache\FileCache;

$cache = new FileCache;

$updatedTime = $cache->refresh('updatedTime', function () {
    return date("H:i:s");
});

echo "Updated time: {$updatedTime}";
```

Önbellek dosyaları varsayılan olarak `./cache` dizininde saklanır;

```
$ tree ./cache
./cache
└── f7
    └── d1
        └── 7411a1eeb3dabcc2311f04eeb5371f0f40f192f3.cache
```

```php
use Mlevent\FileCache\FileCache;

// Önbellek dosyaları ./cache dizininde saklanacak
$cache = new FileCache('./cache');

// Geçerlilik süresi dolduysa
if ($cache->isExpired('updatedTime')) {

    // Geçerlilik süresini 60 saniye daha uzat ve yeni veriyi yaz
    $cache->put('updatedTime', date("H:i:s"), 60);
}

// Veriyi önbellekten oku
$updatedTime = $cache->get('updatedTime');

echo "Updated time: {$updatedTime}";
```

## 📧İletişim

İletişim için ghergedan@gmail.com adresine e-posta gönderin.
