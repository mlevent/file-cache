<?php

declare(strict_types=1);

namespace Mlevent\FileCache;

use Mlevent\FileCache\Exceptions\FileCacheException;

class FileCache
{
    private array  $cacheStore     = [];
    private string $cachePath      = 'cache';
    private string $cacheExtension = '.cache';

    /**
     * setCachePath
     */
    public function setCachePath(string $cachePath) : self {
        $this->cachePath = $cachePath;
        return $this;
    }

    /**
     * setCacheExtension
     */
    public function setCacheExtension(int $cacheExtension) : self {
        $this->cacheExtension = $cacheExtension;
        return $this;
    }

    /**
     * refreshIfExpired
     */
    public function refreshIfExpired(string $name, callable $refreshCallback, int $expiration = 60) : mixed {
        if ($this->isExpired($name)) {
            $this->delete($name);
        }
        if ($cache = $this->get($name)) {
            return $cache;
        } else {
            $runCallback = $refreshCallback();
            $this->put($name, $runCallback, $expiration);
            return $runCallback;
        }
    }

    /**
     * put
     */
    public function put(string $name, mixed $data, int $expiration = 60) : bool {
        if (!$expiration) {
            return false;
        }
        if (!is_dir($this->cachePath) && !mkdir($this->cachePath, 0755, true)) {
            throw new FileCacheException('Failed to create cache folder.');
        }
        $fileContent = [
            'name'       => $name,
            'expiryTime' => time() + $expiration,
            'data'       => $data,
        ];
        $this->addCacheStore(...$fileContent);
        return (bool) file_put_contents($this->getFilePath($fileContent['name']), serialize($fileContent));
	}

    /**
     * get
     */
    public function get(string $name, bool $onlyData = true) : mixed {
        if ($this->has($name)) {
            $resolveCachedData = !$this->hasCacheStore($name)
                ? unserialize(file_get_contents($this->getFilePath($name)))
                : $this->getCacheStore($name);
            $this->addCacheStore(...array_merge($resolveCachedData, [
                'isReadFromDisk' => true
            ]));
            return $onlyData ? $resolveCachedData['data'] : $resolveCachedData;
        }
        return false;
	}

    /**
     * has
     */
    public function has(string $name) : bool {
        return file_exists($this->getFilePath($name));
    }

    /**
     * isExpired
     */
    public function isExpired(string $name) : bool {
        if ($cache = $this->get($name, false)) {
            return (time() >= $cache['expiryTime']);
        }
        return true;
    }

    /**
     * delete
     */
    public function delete(string $name) : bool {
        if ($this->has($name)) {
            return unlink($this->getFilePath($name));
        }
        return false;
    }

    /**
     * flush
     */
    public function flush() : int {
        $affectedRows = 0;
        foreach(glob($this->cachePath . '/*') as $fileName) {
            if (is_file($fileName) && str_ends_with($fileName, $this->cacheExtension)) {
                unlink($fileName); $affectedRows++;
            }
        }
        return $affectedRows;
    }

    /**
     * getFilePath
     */
    private function getFilePath(string $name) : string {
        return join(DIRECTORY_SEPARATOR, [$this->cachePath, sha1($name, false) . $this->cacheExtension]);
	}

    /**
     * pushStorage
     */
    private function addCacheStore(string $name, int $expiryTime, mixed $data, bool $isReadFromDisk = false) : void {
        $this->cacheStore[$name] = [
            'name'           => $name,
            'expiryTime'     => $expiryTime,
            'isReadFromDisk' => $isReadFromDisk,
            'data'           => $data,
        ];
    }

    /**
     * hasCacheStore
     */
    private function hasCacheStore(string $name) : bool {
        return array_key_exists($name, $this->getCacheStore());
    }

    /**
     * getCacheStore
     */
    public function getCacheStore(?string $name = null) : array {
        return (!is_null($name) && $this->hasCacheStore($name)) 
            ? $this->cacheStore[$name] 
            : $this->cacheStore;
    }
}