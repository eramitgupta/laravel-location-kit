<?php

namespace LaravelLocationKit\Support;

use Closure;
use Illuminate\Support\Facades\Cache;

class LocationCache
{
    public static function remember(string $key, Closure $callback): mixed
    {
        if (! config('location-kit.cache.enabled', true)) {
            return $callback();
        }

        self::registerKey($key);

        return Cache::remember(self::key($key), config('location-kit.cache.ttl', 86400), $callback);
    }

    public static function flush(): void
    {
        foreach (Cache::get(self::registryKey(), []) as $key) {
            Cache::forget(self::key($key));
        }

        Cache::forget(self::registryKey());
    }

    public static function key(string $key): string
    {
        return trim(config('location-kit.cache.prefix', 'location-kit').':'.$key, ':');
    }

    protected static function registerKey(string $key): void
    {
        $keys = Cache::get(self::registryKey(), []);

        if (! in_array($key, $keys, true)) {
            $keys[] = $key;
            Cache::put(self::registryKey(), $keys, config('location-kit.cache.ttl', 86400));
        }
    }

    protected static function registryKey(): string
    {
        return self::key('keys');
    }
}
