<?php

namespace Kibatic\CmsBundle\Controller;

use Kibatic\CmsBundle\BlockTypeChain;
use Kibatic\CmsBundle\Entity\Block;
use Kibatic\CmsBundle\Repository\BlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BlockController extends Controller
{
    public function indexAction()
    {
        $this->assertIsCmsAdmin();

        $em = $this->getDoctrine()->getManager();

        $blocks = $em->getRepository(Block::class)->findAll();

        $blockTypeNames = $this->get(BlockTypeChain::class)->getBlockTypeNames();

        return $this->render('@KibaticCms/block/index.html.twig', [
            'blocks' => $blocks,
            'blockTypeNames' => $blockTypeNames
        ]);
    }

    public function newAction(Request $request, string $typeName)
    {
        $this->assertIsCmsAdmin();

        $blockType  = $this->get(BlockTypeChain::class)->getBlockType($typeName);

        $block = new Block();

        $slug = $request->get('slug');

        if ($slug !== null) {
            $block->setSlug($slug);
        }

        $formTypeClass = get_class($blockType);
        $form = $this->createForm(new $formTypeClass, $block);

        $block->setType($blockType::getBlockTypeName());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
            $em->flush();

            return $this->redirectToRoute('cms_block_index');
        }

        return $this->render('@KibaticCms/block/new.html.twig', [
            'block' => $block,
            'form' => $form->createView(),
        ]);
    }

    public function showAction(Request $request, string $slug, string $template = null)
    {
        /**
         * @var Block $block
         */
        $block = $this->get(BlockRepository::class)->findOneBy(['slug' => $slug]);

        if ($block !== null && $template === null) {
            $template = 'KibaticCmsBundle:block:_' . $block->getType() . '_block.html.twig';
        }

        $mainTemplate = $this->get('request_stack')->getMasterRequest() === $request ?
            'KibaticCmsBundle:block:show.html.twig' :
            'KibaticCmsBundle:block:show_content.html.twig'
        ;

        return $this->render($mainTemplate, [
            'block' => $block,
            'slug' => $slug,
            'template' => $template
        ]);
    }

    public function editAction(Request $request, Block $block)
    {
        $blockType  = $this->get(BlockTypeChain::class)->getBlockType($block->getType());

        $deleteForm = $this->createDeleteForm($block);

        $formTypeClass = get_class($blockType);
        $editForm = $this->createForm(new $formTypeClass, $block);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cms_block_edit', ['id' => $block->getId()]);
        }

        return $this->render('@KibaticCms/block/edit.html.twig', [
            'block' => $block,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function deleteAction(Request $request, Block $block)
    {
        $this->assertIsCmsAdmin();

        $form = $this->createDeleteForm($block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($block);
            $em->flush();
        }

        return $this->redirectToRoute('cms_block_index');
    }

    /**
     * @param Block $block
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Block $block)
    {
        return $this->get('form.factory')->createNamedBuilder('block_delete_' . $block->getId())
            ->setAction($this->generateUrl('cms_block_delete', ['id' => $block->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function editModeToggleAction(Request $request)
    {
        $session = $this->get('session');
        $session->set('cms_edit_mode', !$session->get('cms_edit_mode', false));

        $redirectTo = $request->headers->get('referer');

        if ($redirectTo === null) {
            $redirectTo = $this->generateUrl('homepage');
        }

        return $this->redirect($redirectTo);
    }

    private function assertIsCmsAdmin()
    {
//        if (!$this->isGranted(['ROLE_CMS_ADMIN'])) {
//            throw new AccessDeniedHttpException('You need the ROLE_CMS_ADMIN role.');
//        }
    }
}
