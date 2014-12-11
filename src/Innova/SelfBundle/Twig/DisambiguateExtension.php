<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class TaskController
 * @Route("", name = "", service = "innova.twig.disambiguate"
 * )
 */
class DisambiguateExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('disambiguate', array($this, 'disambiguateFilter')),
        );
    }

    public function disambiguateFilter($texte)
    {
        $count = 0;
        $texte = preg_replace_callback('/#([^#]+)#/',  function ($match) use (&$count) {
            $str = "#$count#{$match[1]}#";
            $count++;

            return $str;
        },
        $texte
        );

        return $texte;
    }

    public function getName()
    {
        return 'disambiguate';
    }
}
