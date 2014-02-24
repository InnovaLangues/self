<?php

namespace Innova\SelfBundle\Controller;

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
     * @Route("/session-consigne-or-context-listen-number", name="sessionConsigneOrContextListenNumber", options={"expose"=true})
     * @Method("GET")
     */
    public function sessionConsigneOrContextListenNumberAction()
    {
        $consigneListenNumber = null;

        $session = $this->container->get('request')->getSession();

        if ($session->get('consigneListenNumber')) {
            $consigneListenNumber = $session->get('consigneListenNumber');
        }

        return new JsonResponse(
            array('consigneOrContextListenNumber' => $consigneListenNumber)
        );
    }

    /**
     * To incremente the variable session + 1.
     *
     * @Route("/increment-session-consigne-or-context-listen-number", name="incrementeSessionConsigneOrContextListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function incrementeSessionConsigneOrContextListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $consigneListenNumber = $session->get('consigneListenNumber');

        if ($consigneListenNumber === null) {
            $consigneListenNumber = 0;
        }

        $nextConsigneListenNumber = $consigneListenNumber + 1;
        $session->set('consigneListenNumber', $nextConsigneListenNumber);

        return new JsonResponse(
            array('consigneOrContextListenNumber' => $nextConsigneListenNumber)
        );
    }

    /**
     * To reset the variable session to null.
     *
     * @Route("/reset-session-consigne-or-context-listen-number", name="resetSessionConsigneOrContextListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function resetSessionConsigneOrContextListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $consigneListenNumber = $session->set('consigneListenNumber', null);

        return new JsonResponse(
            array('consigneOrContextListenNumber' => $consigneListenNumber)
        );
    }

}
