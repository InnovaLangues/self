<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;


class PlayerController extends Controller
{
    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     *
     * @Route("student/test/start/{id}", name="test_start")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test)
    {

        $session = $this->container->get('request')->getSession();

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        // Je parcours tous les questionnaires du test X
        // et je m'arrête au premier questionnaire qui n'a pas de trace.
        $findQuestionnaireWithoutTrace = false;
        $questionnaireWithoutTrace = new Questionnaire();

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();
        foreach ($questionnaires as $questionnaire) {

            $tests = $questionnaire->getTests();
            $testQ = $tests[0];

            if ($test->getId() === $testQ->getId()) {
                // Recherche des traces pour UN utilisateur UN test et UN questionnaire.
                $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user->getId(), 'test' => $test->getId(),
                                            'questionnaire' => $questionnaire->getId()
                                            )
                                        );

                    // Si je n'ai pas de traces, alors il faut que j'affiche ce questionnaire. Car il n'est pas encore été "répondu".
                    if (count($traces) == 0) {
                        if (!$findQuestionnaireWithoutTrace) {
                            $questionnaireWithoutTrace = $questionnaire;
                            $findQuestionnaireWithoutTrace = true;
                        }
                    }
                }
        }

        // Et j'affecte à la variable passée à la vue le premier questionnaire sans trace.
        $questionnaire = $questionnaireWithoutTrace;

        $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countDoneYetByUserByTest($test->getId(), $user->getId());

        // Session to F5 key and sesion.
        $session->set('listening', $questionnaire->getListeningLimit());

        // Renvoi vers la méthode indiquant la fin du test.
        if (!$findQuestionnaireWithoutTrace) {
            return $this->redirect(
                $this->generateUrl(
                    'test_end',
                    array("id"=>$test->getId())
                )
            );
        }

        // One color per language. Two languages for the moment : ang and it.
        // In database, we must have one color per test. Table : language.
        // See main.css for more information.
        $language = $em->getRepository('InnovaSelfBundle:Language')->findBy(array('id' => $test->getLanguage()->getId()));
        $languageColor = $language[0]->getColor();

        $questionnaires = $test->getQuestionnaires();

        return array(
            'questionnaire' => $questionnaire,
            'language' => $languageColor,
            'test' => $test,
            'counQuestionnaireDone' => $countQuestionnaireDone,
            'questionnaires' => $questionnaires
        );
    }

     /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     *
     * @Route("/test_end/{id}", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     */
    public function endAction(Test $test)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $nbRightAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->countRightAnswerByUserByTest($test->getId(), $user->getId());

        $nbAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->countAnswerByUserByTest($test->getId(), $user->getId());

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
    public function PickAQuestionnaireAction(Test $test, Questionnaire $questionnairePicked)
    {

        $session = $this->container->get('request')->getSession();
        $session->set('listening', $questionnairePicked->getListeningLimit());
        $em = $this->getDoctrine()->getManager();

        $language = $em->getRepository('InnovaSelfBundle:Language')->findBy(array('id' => $test->getLanguage()->getId()));
        $languageColor = $language[0]->getColor();

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
            'language' => $languageColor,
            'test' => $test,
            'counQuestionnaireDone' => $countQuestionnaireDone,
            'questionnaires' => $questionnaires
        );
    }

}