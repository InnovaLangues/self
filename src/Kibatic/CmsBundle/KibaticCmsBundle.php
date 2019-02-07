<?php

namespace Kibatic\CmsBundle;

use Kibatic\CmsBundle\DependencyInjection\CompilerPass\BlockCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KibaticCmsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new BlockCompilerPass());
    }
}
