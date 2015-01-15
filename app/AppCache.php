<?php

require_once __DIR__.'/AppKernel.php';

use FOS\HttpCacheBundle\SymfonyCache\EventDispatchingHttpCache;

class AppCache extends EventDispatchingHttpCache
{
}