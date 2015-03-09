<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Manager\PlayerManager;

/**
 * Class PlayerController
 *
 * @Route(
 *      "",
 *      name = "innova_player",
 *      service = "innova_player"
 * )
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 */
class PlayerController
{
    protected $securityContext;
    protected $entityManager;
    protected $session;
    protected $router;
    protected $user;
    protected $playerManager;

    public function __construct(
        SecurityContextInterface $securityContext,
        EntityManager $entityManager,
        SessionInterface $session,
        RouterInterface $router,
        PlayerManager $playerManager
    ) {
        $this->securityContext = $securityContext;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->router = $router;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->playerManager = $playerManager;
        $this->questionnaireRepo = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire');
    }

    /**
     * Try to pick a questionnaire entity for a given test and a given sessionr
     * and display it if possible.
     *
     * @Route("student/test/start/{testId}/{sessionId}", name="test_start")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test, Session $session)
    {
        $em = $this->entityManager;

        $orderQuestionnaire = $this->playerManager->pickQuestionnaire($test, $session);

        if (is_null($orderQuestionnaire)) {
            $url = $this->router->generate('test_end', array("testId" => $test->getId(), 'sessionId' => $session->getId()));

            return new RedirectResponse($url);
        } else {
            $questionnaire = $orderQuestionnaire->getQuestionnaire();
            $component = ($test->getPhased()) ? $orderQuestionnaire->getComponent() : null;
            $countQuestionnaireDone = $this->questionnaireRepo->countDoneYetByUserByTest($test->getId(), $this->user->getId());
            $questionnaires = $this->questionnaireRepo->getByTest($test);
            $countQuestionnaireTotal = count($questionnaires);

            return array(
                'test' => $test,
                'session' => $session,
                'component' => $component,
                'questionnaire' => $questionnaire,
                'questionnaires' => $questionnaires,
                'countQuestionnaireDone' => $countQuestionnaireDone,
                'countQuestionnaireTotal' => $countQuestionnaireTotal,
            );
        }
    }

     /**
     * Gère la vue de fin de test
     *
     * @Route("/test_end/{testId}/session/{sessionId}", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     * @Method("GET")
     */
    public function endAction(Test $test, Session $session)
    {
        $nbRightAnswer = $this->questionnaireRepo->countRightAnswerByUserByTest($test->getId(), $this->user->getId());
        $nbAnswer = $this->questionnaireRepo->countAnswerByUserByTest($test->getId(), $this->user->getId());
        $pourcentRightAnswer = number_format(($nbRightAnswer/$nbAnswer)*100, 0);

        return array("pourcentRightAnswer" => $pourcentRightAnswer);
    }

    /**
     * @Route(
     *      "admin/test/{testId}/questionnaire/{questionnaireId}",
     *      name="questionnaire_pick"
     * )
     * @ParamConverter("test", class="InnovaSelfBundle:Test", options={"mapping": {"testId": "id" }})
     * @ParamConverter("questionnairePicked", class="InnovaSelfBundle:Questionnaire", options={"mapping": {"questionnaireId": "id"}})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function pickAQuestionnaireAction(Test $test, Questionnaire $questionnairePicked)
    {
        $em = $this->entityManager;

        $questionnaires = $this->questionnaireRepo->getByTest($test);

        $i = 0;
        foreach ($questionnaires as $q) {
            if ($q == $questionnairePicked) {
                $countQuestionnaireDone = $i;
                break;
            }
            $i++;
        }

        return array(
            'test' => $test,
            'questionnaires' => $questionnaires,
            'questionnaire' => $questionnairePicked,
            'countQuestionnaireDone' => $countQuestionnaireDone,
        );
    }
}
