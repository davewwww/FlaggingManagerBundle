<?php

namespace Dwo\FlaggingManagerBundle\CacheWarmer;

use Doctrine\Common\Cache\Cache;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

/**
 * Class DoctrineCacheWarmer
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class DoctrineCacheWarmer extends CacheWarmer
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir)
    {
        $this->cache->save('__cachewarmer', '');
        $this->cache->delete('__cachewarmer');
    }

    /**
     * @return bool always true
     */
    public function isOptional()
    {
        return true;
    }
}
