<?php

namespace Innova\SelfBundle\Manager;

use Symfony\Component\HttpFoundation\Request;

class LocaleManager
{
    private $securityContext;
    private $userManager;

    public function __construct($securityContext, $userManager)
    {
        $this->securityContext = $securityContext;
        $this->userManager = $userManager;
    }

    /**
     * Set locale setting for current user if this locale is present in the platform.
     *
     * @param string $locale The locale string as en, fr, es, etc.
     */
    public function setUserLocale($locale)
    {
        if ($this->getCurrentUser()) {
            $this->userManager->setLocale($this->getCurrentUser(), $locale);
        }
    }

    /**
     * This methond returns the user locale and store it in session, if there is no user this method return default
     * language or the browser language if it is present in translations.
     *
     * @return string The locale string as en, fr, es, etc.
     */
    public function getUserLocale(Request $request)
    {
        $locale = 'fr';

        switch (true) {
            case ($locale = $request->attributes->get('_locale')): break;
            case (($user = $this->getCurrentUser()) && ($locale = $user->getLocale()) !== ''): break;
            case ($locale = $request->getSession()->get('_locale')): break;
        }

        $request->getSession()->set('_locale', $locale);

        return $locale;
    }

    /**
     * Get Current User.
     */
    private function getCurrentUser()
    {
        if (is_object($token = $this->securityContext->getToken()) && is_object($user = $token->getUser())) {
            return $user;
        }
    }
}
