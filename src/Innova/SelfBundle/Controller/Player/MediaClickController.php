<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\MediaClick;

/**
 * MediaClick controller.
 *
 * @Route("/ajax")
 */
class MediaClickController extends Controller
{

    /**
     * @Route("/get-remaining-listening", name="get-remaining-listening", options={"expose"=true})
     * @Method("GET")
     */
    public function getRemainingListeningAction()
    {
        $request = $this->get('request')->query;
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $remainingListening = $this->getRemainingListening($media, $test, $questionnaire);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );

    }

    /**
     * @Route("/increment-media-clicks", name="increment-media-clicks", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function incrementMediaClicksAction()
    {
        $request = $this->get('request')->query;
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $user = $this->get('security.context')->getToken()->getUser();

        $mediaClick = new MediaClick();
        $mediaClick->setMedia($media);
        $mediaClick->setUser($user);
        $mediaClick->setTest($test);
        $mediaClick->setQuestionnaire($questionnaire);

        $em->persist($mediaClick);
        $em->flush();

        $remainingListening = $this->getRemainingListening($media, $test, $questionnaire);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );

    }

    /**
     * @Route("/is-media-playable", name="is-media-playable", options={"expose"=true})
     * @Method("GET")
     */
    public function checkMediaClicksAction(Request $request)
    {
        $isPlayable = false;

        $request = $this->get('request')->query;
        $em = $this->getDoctrine()->getManager();


        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $isPlayable = $this->isMediaPlayable($media, $test, $questionnaire);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );

    }

    private function isMediaPlayable($media, $test, $questionnaire)
    {
        $em = $this->getDoctrine()->getManager();

        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire);
        $mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findOneBy(array(
                                                                                    'media' => $media,
                                                                                    'questionnaire' => $questionnaire
                                                                                ));

        if(is_null($mediaLimit) || $mediaLimit->getListeningLimit() > $nbClick || $mediaLimit->getListeningLimit() === 0 ){
            return true;
        } else {
            return false;
        }
    }

    private function getMediaClickCount($media, $test, $questionnaire)
    {
        $em = $this->getDoctrine()->getManager();

        $mediaClicks = $em->getRepository('InnovaSelfBundle:MediaClick')
                        ->findBy(array(
                                        'media' => $media,
                                        'test' => $test,
                                        'questionnaire' => $questionnaire
                                      )
                                );

        return count($mediaClicks);
    }

    private function getRemainingListening($media, $test, $questionnaire)
    {
        $em = $this->getDoctrine()->getManager();

        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire);
        $mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findOneBy(array(
                                                                                    'media' => $media,
                                                                                    'questionnaire' => $questionnaire
                                                                                ));

        if(is_null($mediaLimit) || $mediaLimit->getListeningLimit() == 0){
            $remainingListening = "X";
        } else {
            $remainingListening = $mediaLimit->getListeningLimit() - $nbClick;
        }

        return $remainingListening;
    }
}
