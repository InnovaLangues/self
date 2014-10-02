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
    )
    {
        $this->securityContext = $securityContext;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->router = $router;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->playerManager = $playerManager;
    }

    /**
     * Try to pick a questionnaire entity for a given test not done yet by the user
     * and display it if possible.
     *
     * @Route("student/test/start/{id}/{displayHelp}/", name="test_start")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test, $displayHelp)
    {
        $em = $this->entityManager;

        $questionnaire = $this->playerManager->findAQuestionnaireWithoutTrace($test);
        if (is_null($questionnaire)) {
            return new RedirectResponse($this->router->generate('test_end',array("id"=>$test->getId())));
        } else {
            /* en attendant que les videos soient prêtes
            if ($displayHelp){
                    $displayHelp = $this->playerManager->displayHelp($test, $questionnaire);
            }
            */
            $displayHelp = false;
            $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $this->user->getId());
            $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);
            $countQuestionnaireTotal = count($questionnaires);

            return array(
                'test' => $test,
                'questionnaire' => $questionnaire,
                'questionnaires' => $questionnaires,
                'countQuestionnaireDone' => $countQuestionnaireDone,
                'countQuestionnaireTotal' => $countQuestionnaireTotal,
                'displayHelp' => $displayHelp
            );
        }
    }
    
     /**
     * Gère la vue de fin de test
     *
     * @Route("/test_end/{id}", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     * @Method("GET")
     */
    public function endAction(Test $test)
    {
        $em = $this->entityManager;

        $nbRightAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->countRightAnswerByUserByTest($test->getId(), $this->user->getId());

        $nbAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->countAnswerByUserByTest($test->getId(), $this->user->getId());

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

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);

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
            'displayHelp' => false
        );
    }

}
