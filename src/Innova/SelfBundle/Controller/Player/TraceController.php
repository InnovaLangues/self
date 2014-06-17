<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Answer;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Proposition;

class TraceController extends Controller
{
    /**
     * Save Trace and display a form to set the difficulty
     *
     * @Route("trace_submit", name="trace_submit")
     * @Method({"GET", "POST"})
     * @Template("")
     */
    public function saveTraceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->get('request')->request->all();

//var_dump($post);die();
echo "Q : " . $post["questionnaireId"];
echo "<br />";
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($post["questionnaireId"]);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($post["testId"]);
        $user = $this->get('security.context')->getToken()->getUser();

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countTraceByUserByTestByQuestionnaire($test->getId(), $questionnaire->getId(), $user->getId());

        if ($countTrace > 0) {
            $this->get('session')->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');

            return array("traceId" => 0, "testId" => $test->getId());
        }

        $trace = $this->createTrace($questionnaire, $test, $user, $post["totalTime"]);

        $this->parsePost($post, $trace);

        $session = $this->container->get('request')->getSession();
        $session->set('traceId', $trace->getId());
        $session->set('testId', $post["testId"]);

        return $this->redirect($this->generateUrl('display_difficulty'));
    }


    /**
     * display a form to set the difficulty
     *
     * @Route("display_difficulty", name="display_difficulty")
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     * @Method("GET")
     */
    public function displayDifficultyFormAction()
    {

        $session = $this->container->get('request')->getSession();
        $traceId = $session->get('traceId');
        $testId = $session->get('testId');

        return array("traceId" => $traceId, "testId" => $testId);
    }


    /**
     * Parse post var
     */
    private function parsePost($post, $trace)
    {
        $this->get('session')->getFlashBag()->set('success', 'Votre réponse a bien été enregistrée.');

var_dump($post);
        foreach ($post as $subquestionId => $postVar) {
echo $subquestionId;
            // Cas classique
            if (is_array($postVar)) {
var_dump($postVar);
                foreach ($postVar as $key => $propositionId) {
echo "<br />Prop=" . $propositionId;
die();
                    // SAISIE d'une valeur et non pas choix dans une liste


//        echo "propositionId" . $propositionId;
//                  // Deux cas :
                    // Cas 1 : si la proposition est de type numéric alors on est dans le cas d'un choix dans une liste
                    if (is_numeric($propositionId)) {
//        echo "is_numeric";
                        foreach ($postVar as $key => $propositionId) {
                            $this->createAnswer($trace, $propositionId, $subquestionId);
                        }
                    }
                    // Cas 2 : si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE
                    else {
                            // Du coup, je récupère l'indice (la clé) dans le tableau $post
                            // Et le résultat de la recherche me donne le NUMERO de la subquestion.
                            //$subquestionId = array_search($propositionId, $postVar);
                            //echo "<br />P=" . $propositionId;
                            //echo "  S=". $subquestionId;
//        echo "is_string";
                        foreach ($postVar as $key => $propositionId) {
                            $this->createAnswerProposition($trace, $propositionId, $subquestionId);
                        }
                    }
                }
            }
        }
    }


    /**
     * Create and return a trace
     */
    private function createTrace($questionnaire, $test, $user, $totalTime)
    {
        $em = $this->getDoctrine()->getManager();

        $trace = new Trace();

        $trace->setDate(new \DateTime());
        $trace->setQuestionnaire($questionnaire);
        $trace->setTest($test);
        $trace->setUser($user);
        $trace->setTotalTime($totalTime);
        $trace->setListeningTime("");
        $trace->setListeningAfterAnswer("");
        $trace->setClickCorrectif("");
        $trace->setIp("");
        $trace->setuserAgent("");
        $trace->setDifficulty("");

        $em->persist($trace);
        $em->flush();

        return $trace;
    }


    /**
     * si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE
     */
    private function createAnswerProposition($trace, $postVar, $subquestionId)
    {

        echo "postVar" . $postVar;die();
        //echo "createAnswerProposition";
        $em = $this->getDoctrine()->getManager();

        $answer = new Answer();

        $answer->setTrace($trace);
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $answer->setSubquestion($subquestion);

        $typo = $subquestion->getTypology()->getName();

        // Si on est sur une saisie ...
        if ($typo == "TLQROCDERIV" or $typo == "TLQROCFIRST" or $typo == "TLQROCSYL"
        or $typo == "TLQROCNOCLU" or $typo == "TLQROCLEN" or $typo == "TLQROCFIRSTLEN") {


                $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
                // 1 : création d'une ligne dans Media
                $media = new Media();
                $media->setDescription($postVar);
                $media->setName($postVar);
                //$media->setUrl();
                $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
                // Enregistrement en base
                $em->persist($media);

                // 2 : création d'une ligne dans Proposition
                $propositionAnwser = new Proposition();
                $propositionAnwser->setSubquestion($subquestion);
                $propositionAnwser->setMedia($media);
                $propositionAnwser->setRightAnswer(0);
                // Enregistrement en base
                $em->persist($propositionAnwser);

                $answer->setProposition($propositionAnwser);
        }

        $em->persist($answer);

        $em->flush();

        return $answer;
    }


    /**
     * si la proposition est de type numéric alors on est dans le cas d'un choix dans une liste
     */
    private function createAnswer($trace, $propositionId, $subquestionId)
    {
        $em = $this->getDoctrine()->getManager();

        $answer = new Answer();

        $answer->setTrace($trace);
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $answer->setSubquestion($subquestion);

        $typo = $subquestion->getTypology()->getName();

echo "T : " . $typo;
        // Si on est sur un QROC ...
        if ($typo == "TLCMLDMZZZ") {
            $propositionSub = $em->getRepository('InnovaSelfBundle:Proposition')->
                findBy(array('subquestion' => $subquestionId));
            //find($propositionId);
//            $rightText = $propositionSub->getMedia()->getName();
            $rightText = $propositionSub[0]->getMedia()->getName();

            if ( $propositionId != $rightText ) {
                // La saisie n'est pas bonne.
                // 1 : création d'une ligne dans Media
                $media = new Media();
                $media->setDescription($propositionId);
                $media->setName($propositionId);
                //$media->setUrl();
                $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
                // Enregistrement en base
                $em->persist($media);
                // 2 : création d'une ligne dans Proposition
                $propositionAnwser = new Proposition();
                $propositionAnwser->setSubquestion($subquestion);
                $propositionAnwser->setMedia($media);
                $propositionAnwser->setRightAnswer(0);

                // Enregistrement en base
                $em->persist($propositionAnwser);

            }
        }
        // Si on N'est PAS sur un QROC.
        elseif ($typo == "TLCMQRU" or $typo == "TLCMTQRU" or $typo == "TLCMLDM" or $typo == "TLQROCDCTM" or $typo == "TLQROCDCTU") {
            $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
            $answer->setProposition($proposition);
        }

        $em->persist($answer);

        $em->flush();

        return $answer;
    }


    /**
     * update a trace to set the difficulty
     *
     * @Route("trace_setDifficulty", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function traceSetDifficultyAction()
    {

        $em = $this->getDoctrine()->getManager();
        $post = $this->get('request')->request->all();

        $trace = $em->getRepository('InnovaSelfBundle:Trace')->find($post["traceId"]);
        $trace->setDifficulty($post["difficulty"]);
        $em->persist($trace);
        $em->flush();

        return $this->redirect($this->generateUrl('test_start', array('id' => $post["testId"])));
    }

}
