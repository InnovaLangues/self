<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiController extends Controller
{
    /**
     * @Route("api/_stats", name = "api-stats")
     * @Method("GET")
     */
    public function getStatsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $authCount = $this->get('self.user.manager')->getAuthCount();
        $registeredCount = $em->getRepository('InnovaSelfBundle:User')->getRegisteredCount();
        $openCount = $em->getRepository('InnovaSelfBundle:Session')->getOpenCount();

        $data = array(
            'auth_users' => $authCount,
            'registered_users' => $registeredCount,
            'open_session' => $openCount,
        );

        $response = new JsonResponse();
        $response->setData($data);

        return $response;
    }
}
