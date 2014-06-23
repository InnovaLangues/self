<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * Select a language
     *
     * @Route("/locale/select", name="claroline_locale_select", options = {"expose" = true})
     *
     * @Template("ClarolineCoreBundle:Locale:select.html.twig")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectLangAction()
    {
        return array('locales' => $this->localeManager->getAvailableLocales());
    }

    /**
     * Change locale
     *
     * @Route("/locale/change/{_locale}", name="locale_change", options = {"expose" = true})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeLocale($_locale)
    {
        $this->localeManager->setUserLocale($_locale);

        return new Response(200);
    }
}
