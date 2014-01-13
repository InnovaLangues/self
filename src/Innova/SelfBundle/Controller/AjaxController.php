<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @Route("/session-consigne-listen-number", name="sessionConsigneListenNumber", options={"expose"=true})
     * @Method("GET")
     */
    public function sessionConsigneListenNumberAction()
    {
        $consigneListenNumber = null;

        $session = $this->container->get('request')->getSession();

        if ($session->get('consigneListenNumber')) {
            $consigneListenNumber = $session->get('consigneListenNumber');
        }

        return new JsonResponse(
            array('consigneListenNumber' => $consigneListenNumber)
        );
    }

    /**
     * To incremente the variable session + 1.
     *
     * @Route("/increment-session-consigne-listen-number", name="incrementeSessionConsigneListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function incrementeSessionConsigneListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $consigneListenNumber = $session->get('consigneListenNumber');

        if ($consigneListenNumber === null) {
            $consigneListenNumber = 0;
        }

        $nextConsigneListenNumber = $consigneListenNumber + 1;
        $session->set('consigneListenNumber', $nextConsigneListenNumber);

        return new JsonResponse(
            array('consigneListenNumber' => $nextConsigneListenNumber)
        );
    }

    /**
     * To reset the variable session to null.
     *
     * @Route("/reset-session-consigne-listen-number", name="resetSessionConsigneListenNumber", options={"expose"=true})
     * @Method("PUT")
     */
    public function resetSessionConsigneListenNumberAction()
    {

        $session = $this->container->get('request')->getSession();

        $consigneListenNumber = $session->set('consigneListenNumber', null);

        return new JsonResponse(
            array('consigneListenNumber' => $consigneListenNumber)
        );
    }

}
