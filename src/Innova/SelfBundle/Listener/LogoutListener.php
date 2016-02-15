<?php

namespace Innova\SelfBundle\Listener;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutListener implements LogoutSuccessHandlerInterface
{
    private $security;

    public function __construct(SecurityContext $security, $router)
    {
        $this->security = $security;
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request)
    {
        $response = new RedirectResponse($this->router->generate('show_start'));
        $response->headers->clearCookie('self-font-size');
        setcookie('self-font-size', '', time() - 3600);
        unset($_COOKIE['self-font-size']);

        return $response;
    }
}
