<?php
namespace Innova\SelfBundle\Twig;

/**
 * Class TaskController
 * @Route(
 *      "",
 *      name    = "",
 *      service = "innova.twig.get_languages"
 * )
 */
class LanguageExtension extends \Twig_Extension
{
    protected $entityManager;

    public function __construct(
            $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getLanguages()
    {
        $em = $this->entityManager;

        $languages = $em->getRepository('InnovaSelfBundle:Language')->findAll();

        return $languages;
    }

    public function getFunctions()
    {
        return array(
            'get_languages' => new \Twig_Function_Method($this, 'getLanguages'));
    }

    public function getName()
    {
        return 'get_languages';
    }
}
