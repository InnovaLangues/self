<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class HostnameExtension
 * @Route("", name = "", service = "innova.twig.hostname"
 * )
 */
class HostnameExtension extends \Twig_Extension
{
    public function getHostname()
    {
        return gethostname();
    }

    public function getFunctions()
    {
        return array(
            'get_hostname' => new \Twig_Function_Method($this, 'getHostname'), );
    }

    public function getName()
    {
        return 'get_hostname';
    }
}
