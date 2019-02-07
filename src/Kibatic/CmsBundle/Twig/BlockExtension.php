<?php

namespace Kibatic\CmsBundle\Twig;

use Kibatic\CmsBundle\Entity\Block;
use Kibatic\CmsBundle\Repository\BlockRepository;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class BlockExtension extends \Twig_Extension
{
    private $blockRepository;
    private $authorizationChecker;
    private $router;

    public function __construct(
        BlockRepository $blockRepository,
        AuthorizationChecker $authorizationChecker,
        Router $router
    ) {
        $this->blockRepository = $blockRepository;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function(
                'cms_block',
                function (string $slug, bool $strict = false) {
                    /**
                     * @var Block $block
                     */
                    $block = $this->blockRepository->findOneBy(['slug' => $slug]);

                    if ($block === null) {
                        if ($strict) {
                            throw new \Exception('Block "' . $slug . '" does not exist');
                        }

                        if ($this->authorizationChecker->isGranted('ROLE_CMS_ADMIN')) {
                            $url = $this->router->generate('cms_block_new', ['slug' => $slug]);
                            return '<div style="border:1px solid red;padding:5px;">CMS Block "' . $slug . '" does not exist, <a href="' . $url . '">create it.</a></div>';
                        }

                        return null;
                    }

                    return $block->getContent();
                },
                [
                    'is_safe' => [
                        'html'
                    ]
                ]
            ),
        ];
    }
}
