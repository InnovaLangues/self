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
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $questionnaire = $this->findAQuestionnaireWithoutTrace($test, $user);

        if (is_null($questionnaire)) {
            return $this->redirect($this->generateUrl('test_end',array("id"=>$test->getId())));
        } else {
            $languageColor = $test->getLanguage()->getColor();

            $questionnaires = $test->getQuestionnaires();

            $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                ->countDoneYetByUserByTest($test->getId(), $user->getId());

            return array(
                'questionnaire' => $questionnaire,
                'language' => $languageColor,
                'test' => $test,
                'counQuestionnaireDone' => $countQuestionnaireDone,
                'questionnaires' => $questionnaires
            );
        }
    }


    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     */
    public function findAQuestionnaireWithoutTrace($test, $user)
    {
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getManager();

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

        // Session to F5 key and sesion.
        $session->set('listening', $questionnaire->getListeningLimit());

        return $questionnaireWithoutTrace;
    }



     /**
     * Gère la vue de fin de test
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