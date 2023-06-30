<?php

namespace App\Repositories\BaseRepository\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;

trait CacheResults
{
    /**
     * Array of predefined method that should cache.
     */
    protected array $baseCacheableMethods = [
        'getAll',
        'getPaginated',
        'getForSelect',
        'getById',
        'getItemByColumn',
        'getCollectionByColumn',
        'getActively',
    ];

    /**
     * Disable caching on the fly.
     *
     * @return $this
     */
    public function disableCaching(): CacheResults
    {
        $this->caching = false;

        return $this;
    }

    /**
     * Get ttl (minutes).
     */
    protected function getCacheTtl(): int
    {
        return isset($this->cacheTtl) ? $this->cacheTtl : 60;
    }

    protected function isCacheableMethod($methodName): bool
    {
        return in_array($methodName, $this->getCacheableMethods());
    }

    /**
     * Perform the query and cache if required.
     *
     * @return mixed
     */
    protected function processCacheRequest($callback, $method, $args)
    {
        $key = $this->createCacheKey($method, $args);

        return $this->getCache()->remember($key, $this->getCacheTtl(), $callback);
    }

    /**
     * Make a unique key for this specific request.
     *
     * @param $functionName string Name of method to call.
     * @param $args array Argument to pass into the method.
     */
    protected function createCacheKey(string $functionName, array $args): string
    {
        return sprintf('%s.%s.%s', get_class(), $functionName, md5(implode('|', $args)));
    }

    /**
     * returns Illuminate\Contracts\Cache\Repository
     *
     * @throws BindingResolutionException
     */
    protected function getCache(): \Illuminate\Contracts\Cache\Repository
    {
        return app()->make('Illuminate\Contracts\Cache\Repository');
    }

    protected function getCacheableMethods(): array
    {
        $methods = $this->baseCacheableMethods;

        // Include user defined methods.
        if (isset($this->cacheableMethods)) {
            $methods = array_merge($this->baseCacheableMethods, $this->cacheableMethods);
        }

        // Filter any unwanted methods.
        if (isset($this->nonCacheableMethods)) {
            $methods = array_filter($methods, function ($methodName) {
                return ! in_array($methodName, $this->nonCacheableMethods);
            });
        }

        return $methods;
    }
}
