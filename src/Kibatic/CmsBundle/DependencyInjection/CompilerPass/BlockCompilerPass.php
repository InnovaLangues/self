<?php

namespace Kibatic\CmsBundle\DependencyInjection\CompilerPass;

use Kibatic\CmsBundle\BlockTypeChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BlockCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(BlockTypeChain::class)) {
            return;
        }

        $definition = $container->findDefinition(BlockTypeChain::class);

        $taggedServices = $container->findTaggedServiceIds('cms.block_type');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addBlockType', array(new Reference($id)));
        }
    }
}
