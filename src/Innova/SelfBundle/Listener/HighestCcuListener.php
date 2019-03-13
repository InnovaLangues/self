<?php

namespace Innova\SelfBundle\Listener;

use Innova\SelfBundle\GlobalStats;
use Innova\SelfBundle\Manager\KeyValueManager;
use Innova\SelfBundle\Manager\UserManager;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class HighestCcuListener
{
    private $keyValueManager;
    private $userManager;
    private $interactiveLogin = false;

    public function __construct(
        KeyValueManager $keyValueManager,
        UserManager $userManager
    ) {
        $this->keyValueManager = $keyValueManager;
        $this->userManager = $userManager;
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->interactiveLogin = true;
    }

    public function onKernelTerminate()
    {
        if (!$this->interactiveLogin) {
            return;
        }

        $ccu = $this->userManager->getAuthCount();

        $highestCcu = $this->keyValueManager->get(GlobalStats::HIGHEST_CCU, 0);

        if ($ccu < (int) $highestCcu) {
            return;
        }

        $this->keyValueManager->save(GlobalStats::HIGHEST_CCU, $ccu);
        $this->keyValueManager->save(GlobalStats::HIGHEST_CCU_DATE, date('Y-m-d H:i:s'));
    }
}
