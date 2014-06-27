<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Innova\SelfBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class LocaleSetter
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "self.locale.listener"
 * )
 */
class LocaleSetter
{
    private $localeManager;

    public function __construct($localeManager)
    {
        $this->localeManager = $localeManager;
    }

    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $locale = $this->localeManager->getUserLocale($request);
        $request->setLocale($locale);
    }
}
