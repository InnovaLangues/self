<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Route("/session-situation-listen-number", name="sessionSituationListenNumber", options={"expose"=true})
     * @Method("GET")
     */
    public function sessionSituationListenNumberAction()
    {
        $situationListenNumber = null;

        $session = $this->container->get('request')->getSession();

        if ($session->get('situationListenNumber')) {
            $situationListenNumber = $session->get('situationListenNumber');
        }

        return new JsonResponse(
            array('situationListenNumber' => $situationListenNumber)
        );
    }

    /**
     * To incremente the variable session + 1.
     *
     * @Route("/increment-session-situation-listen-number", name="incrementeSessionSituationListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function incrementeSessionSituationListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $situationListenNumber = $session->get('situationListenNumber');

        if ($situationListenNumber === null) {
            $situationListenNumber = 0;
        }

        $nextSituationListenNumber = $situationListenNumber + 1;
        $session->set('situationListenNumber', $nextSituationListenNumber);

        return new JsonResponse(
            array('situationListenNumber' => $nextSituationListenNumber
                 )
        );
    }

    /**
     * To reset the variable session to null.
     *
     * @Route("/reset-session-situation-listen-number", name="resetSessionSituationListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function resetSessionSituationListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $situationListenNumber = $session->set('situationListenNumber', null);

        return new JsonResponse(
            array('situationListenNumber' => $situationListenNumber)
        );
    }

    /**
    * Vérify if the session variable is OK and initialize if not.
    *
    * @Route("/session-context-listen-number", name="sessionContextListenNumber", options={"expose"=true})
    * @Method("GET")
    */
    public function sessionContextListenNumberAction()
    {
        $contextListenNumber = null;

        $session = $this->container->get('request')->getSession();

        if ($session->get('contextListenNumber')) {
            $contextListenNumber = $session->get('contextListenNumber');
        }

        return new JsonResponse(
            array('contextListenNumber' => $contextListenNumber)
        );
    }

    /**
    * To incremente the variable session + 1.
    *
    * @Route("/increment-session-context-listen-number", name="incrementeSessionContextListenNumber", options={"expose"=true})
    * @Method("PUT")
    */
    public function incrementeSessionContextListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $contextListenNumber = $session->get('contextListenNumber');

        if ($contextListenNumber === null) {
            $contextListenNumber = 0;
        }

        $nextContextListenNumber = $contextListenNumber + 1;
        $session->set('contextListenNumber', $nextContextListenNumber);

        return new JsonResponse(
            array('contextListenNumber' => $nextContextListenNumber)
        );
    }

    /**
    * To reset the variable session to null.
    *
    * @Route("/reset-session-context-listen-number", name="resetSessionContextListenNumber", options={"expose"=true})
    * @Method("PUT")
    */
    public function resetSessionContextListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $contextListenNumber = $session->set('contextListenNumber', null);

        return new JsonResponse(
            array('contextListenNumber' => $contextListenNumber)
        );
    }

}
