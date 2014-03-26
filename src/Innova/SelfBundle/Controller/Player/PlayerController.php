<?php

namespace Innova\SelfBundle\Controller\Player;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    /**
     * Class constructor
     */
    public function __construct(
        SecurityContextInterface $securityContext, 
        EntityManager $entityManager, 
        SessionInterface $session,
        RouterInterface $router
    )
    {
        $this->securityContext = $securityContext;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->router = $router;
    }


    /**
     * Try to pick a questionnaire entity for a given test not done yet by the user 
     * and display it if possible.
     *
     * @Route("student/test/start/{id}", name="test_start")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test)
    {
        $em = $this->entityManager;

        // on récupère un questionnaire sans trace pour un test et un utilisateur donné
        $questionnaire = $this->findAQuestionnaireWithoutTrace($test, $this->user);

        // s'il n'y a pas de questionnaire dispo, on renvoie vers la fonction qui gère la fin de test
        if (is_null($questionnaire)) {
            return new RedirectResponse($this->router->generate('test_end',array("id"=>$test->getId())));
        } else {
        // sinon on envoie le questionnaire à la vue
            $this->session->set('listening', $questionnaire->getListeningLimit());

            $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                ->countDoneYetByUserByTest($test->getId(), $this->user->getId());

            return array(
                'questionnaire' => $questionnaire,
                'test' => $test,
                'counQuestionnaireDone' => $countQuestionnaireDone
            );
        }
    }


    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     */
    protected function findAQuestionnaireWithoutTrace($test, $user)
    {
        $em = $this->entityManager;

        $questionnaireWithoutTrace = null;

        $questionnaires = $test->getQuestionnaires();

        foreach ($questionnaires as $questionnaire) {
            $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(
                array('user' => $user->getId(), 
                        'test' => $test->getId(),
                        'questionnaire' => $questionnaire->getId()
                ));
            if (count($traces) == 0) {
                $questionnaireWithoutTrace = $questionnaire;
                break;
            }
        }

        return $questionnaireWithoutTrace;
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
     *
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

        $this->session->set('listening', $questionnairePicked->getListeningLimit());

        $questionnaires = $test->getQuestionnaires();

        $i = 0;
        foreach ($questionnaires as $q) {
            if ($q == $questionnairePicked) {
                $countQuestionnaireDone = $i;
                break;
            }
            $i++;
        }

        return array(
            'questionnaire' => $questionnairePicked,
            'test' => $test,
            'counQuestionnaireDone' => $countQuestionnaireDone,
        );
    }

}