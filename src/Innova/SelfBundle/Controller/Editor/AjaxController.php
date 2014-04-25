<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\Media;

/**
 * Main controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**
     * Vérify if the session variable is OK and initialize if not.
     *
     * @Route("/edit-media", name="edit-media", options={"expose"=true})
     * @Method("GET")
     */
    public function editMedia()
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->container->get('request');
        $mediaId = $request->query->get('id');
        
        $media = $em->getRepository('InnovaSelfBundle:Media')->findOneById($mediaId);


        return new JsonResponse(
            array(
                'id' => $media->getId(),
                'type' => $media->getMediaType()->getName(),
                'description' => $media->getDescription(),
            )
        );
    }


}
