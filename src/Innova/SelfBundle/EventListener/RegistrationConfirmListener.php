<?php
namespace Innova\SelfBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/*
class RegistrationConfirmListener implements EventSubscriberInterface
{

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }


    public static function getSubscribedEvents()
    {
        return array(
                FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationConfirm'
        );
    }

    public function onRegistrationConfirm(GetResponsUeserEvent $event)
    {

        $url = $this->router->generate('show_tests');

        $event->setResponse(new RedirectResponse($url));
    }
}
*/