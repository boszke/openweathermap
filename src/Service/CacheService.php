<?php

namespace App\Service;

use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;

class CacheService
{
    private $cacheInstance;
    
    public function __construct(ExtendedCacheItemPoolInterface $cacheInstance)
    {
        $this->cacheInstance = $cacheInstance;
    }
    
    public function getCache(string $key)
    {
        $cached = $this->cacheInstance->getItem($key);
        
        if (!$cached->isHit()) {
            return null;
        }
        
        return $cached->get();
    }
    
    public function setCache(string $key, $data, int $secondsExpiried = 600)
    {
        $cached = $this->cacheInstance->getItem($key);
        $cached->set($data)->expiresAfter($secondsExpiried);
        $this->cacheInstance->save($cached);
    }
}
