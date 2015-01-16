<?php

require_once __DIR__.'/AppKernel.php';

use FOS\HttpCacheBundle\SymfonyCache\EventDispatchingHttpCache;

//use FOS\HttpCache\SymfonyCache\EventDispatchingHttpCache;
use FOS\HttpCache\SymfonyCache\UserContextSubscriber;

class AppCache extends EventDispatchingHttpCache
{
    /**
     * Overwrite constructor to register event subscribers for FOSHttpCache.
     */
    public function __construct(HttpKernelInterface $kernel, $cacheDir = null)
    {
        parent::__construct($kernel, $cacheDir);

        $this->addSubscriber(new UserContextSubscriber());
    }
}