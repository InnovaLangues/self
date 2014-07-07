<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\MediaClick;

/**
 * MediaClick controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**
     * @Route("/increment-media-click", name="increment-media-click", options={"expose"=true})
     * @Method("GET")
     */
    public function incrementMediaClickAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->request->get('mediaId'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));
        $user = $this->get('security.context')->getToken()->getUser();

        $mediaClick = new MediaClick();
        $mediaClick->setMedia($media);
        $mediaClick->setUser($user);
        $mediaClick->setTest($test);
        $mediaClick->setQuestionnaire($questionnaire);

        $em->persist($mediaClick);
        $em->flush();

        $isPlayable = $this->isMediaPlayable($media, $test, $questionnaire);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );

    }

    /**
     * @Route("/is-media-playable", name="is-media-playable", options={"expose"=true})
     * @Method("GET")
     */
    public function checkMediaClicksAction()
    {
        $isPlayable = false;

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->request->get('mediaId'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));

        $isPlayable = $this->isMediaPlayable($media, $test, $questionnaire);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );

    }

    private function isMediaPlayable($media, $test, $questionnaire)
    {
        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire);
        $mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findBy(array(
                                                                                    'media' => $media,
                                                                                    'test' => $test,
                                                                                    'questionnaire' => $questionnaire
                                                                                ));

        if($mediaLimit || $mediaLimit > $nbClick){
            return true;
        } else {
            return false;
        }
    }

    private function getMediaClickCount($media, $test, $questionnaire)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $mediaClicks = $em->getRepository('InnovaSelfBundle:MediaClick')->findBy(array(
                                                                                    'media' => $media,
                                                                                    'test' => $test,
                                                                                    'questionnaire' => $questionnaire
                                                                                ));

        return count($mediaClicks);
    }
}
