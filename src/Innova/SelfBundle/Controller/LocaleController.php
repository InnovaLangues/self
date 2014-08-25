<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExportTiaController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_locale_controller"
 * )
 */
class LocaleController
{
    private $localeManager;

    public function __construct($localeManager)
    {
        $this->localeManager = $localeManager;
    }


    /**
     * Change locale
     *
     * @Route("/locale/change/{_locale}", name="locale_change", options = {"expose" = true})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeLocale($_locale)
    {
        $this->localeManager->setUserLocale($_locale);

        return new Response(200);
    }
}
