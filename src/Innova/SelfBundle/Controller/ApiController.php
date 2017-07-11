<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\Media\MediaClick;

/**
 * Class ApiController.
 *
 * @Route(
 *      "api/",
 * )
 */
class ApiController extends Controller
{
    /**
     * @Route("_stats", name = "api-stats")
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

    /**
     * @Route("_evoliatis", name = "evoliatis")
     * @Method("GET")
     */
    public function testEvoliatisAction()
    {
        $em = $this->getDoctrine()->getManager();

        // some selects
        $users = [1439, 20, 27256, 3693];
        $medias = [315, 316, 317, 318, 320, 324, 331];
        $tests = [298, 240, 251, 177];
        $sessions = [365, 366, 367];
        $questionnaires = [7056,6051, 6251];


        $user = $em->getRepository('InnovaSelfBundle:User')->find($users[array_rand($users)]);
        $media = $em->getRepository('InnovaSelfBundle:Media\Media')->find($medias[array_rand($medias)]);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($tests[array_rand($tests)]);
        $session = $em->getRepository('InnovaSelfBundle:Session')->find($sessions[array_rand($sessions)]);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaires[array_rand($questionnaires)]);

        // and an insert
        $mediaClick = new MediaClick;
        $mediaClick->setMedia($media);
        $mediaClick->setUser($user);
        $mediaClick->setTest($test);
        $mediaClick->setSession($session);
        $mediaClick->setQuestionnaire($questionnaire);

        $em->persist($mediaClick);
        $em->flush();

        $response = new JsonResponse();

        return $response;
    }
}
