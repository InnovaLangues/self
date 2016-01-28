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
        $authCount = $this->get('self.user.manager')->getAuthCount();

        $data = array('auth_users' => $authCount);

        $response = new JsonResponse();
        $response->setData($data);

        return $response;
    }
}
