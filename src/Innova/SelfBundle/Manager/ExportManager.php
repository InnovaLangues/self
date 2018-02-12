<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Exception\ExportTimeoutException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

class ExportManager
{
    protected $entityManager;
    protected $scoreManager;
    protected $securityContext;
    protected $kernelRoot;
    protected $knpSnappyPdf;
    protected $templating;
    protected $user;

    protected $execTimeLimit = 240;
    protected $execStartedAt = 0;

    public function __construct($entityManager, $scoreManager, $securityContext, $kernelRoot, $knpSnappyPdf, $templating)
    {
        $this->entityManager = $entityManager;
        $this->scoreManager = $scoreManager;
        $this->securityContext = $securityContext;
        $this->kernelRoot = $kernelRoot;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->templating = $templating;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function generateResponse($file)
    {
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Encoding', 'UTF-8');
        $response->headers->set('Content-type', mime_content_type($file).';charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($file).'";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();
        $response->setContent("\xEF\xBB\xBF".file_get_contents($file));

        return $response;
    }

    public function getTaskPosition(Test $test, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        if ($test->getPhased()) {
            $component = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->getByTestAndQuestionnaire($test, $questionnaire);
            if ($component) {
                return $component->getComponentType()->getName();
            }
        }

        return '-';
    }

    public function getUserSecondStep(Session $session, User $user)
    {
        $em = $this->entityManager;
        if ($session->getTest()->getPhased()) {
            if ($trace = $em->getRepository('InnovaSelfBundle:Trace')->getFirstForSecondStep($session, $user)) {
                return $trace->getComponent()->getComponentType()->getName();
            }
        }

        return '-';
    }

    public function exportSessionUserPdfAction(Session $session, User $user)
    {
        $fs = new Filesystem();
        $userId = $user->getId();
        $sessionId = $session->getId();
        $em = $this->entityManager;

        $pdfName = 'self_export-'.$userId.'pdf-session_'.$sessionId.'-'.date('d-m-Y_H:i:s').'.pdf';
        $pdfPathExport = $this->kernelRoot.'/data/user/';
        $fileName = $pdfPathExport.'/'.$pdfName;
        $fs->mkdir($pdfPathExport, 0777);

        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user, 'session' => $session));
        $date = end($traces)->getDate();

        $score = $this->scoreManager->calculateScoreByTest($session->getTest(), $session, $user);
        $levelFeedback = $this->scoreManager->getGlobalScore($session, $user);
        $coFeedback = $this->scoreManager->getSkillScore($session, $user, 'CO');
        $ceFeedback = $this->scoreManager->getSkillScore($session, $user, 'CE');
        $eecFeedback = $this->scoreManager->getSkillScore($session, $user, 'EEC');

        $this->knpSnappyPdf->generateFromHtml(
            $this->templating->render(
                'InnovaSelfBundle:Export:exportUserPdf.html.twig',
                array(
                    'user' => $user, 'score' => $score, 'session' => $session, 'date' => $date,
                    'levelFeedback' => $levelFeedback, 'coFeedback' => $coFeedback, 'ceFeedback' => $ceFeedback, 'eecFeedback' => $eecFeedback,
                )),
                $fileName
        );

        $response = $this->generateResponse($fileName);

        return $response;
    }

    public function generateCsv(Test $test, Session $session, $tia, $startDate, $endDate)
    {
        $fs = new Filesystem();
        $testId = $test->getId();
        $sessionId = $session->getId();

        $format = 'Y-m-d H:i:s';
        $startDate = (!$startDate)
            ? date_create_from_format($format, '1970-01-01 00:00:00')
            : date_create_from_format($format, $startDate);

        $endDate = (!$endDate)
            ? date($format)
            : date_create_from_format($format, $endDate);

        if ($tia == 0) {
            $tia = '';
            $csvContent = $this->getCsvContent($test, $session, $startDate, $endDate);
        } else {
            $tia = '-tia';
            $csvContent = $this->getCsvTiaContent($test, $session, $startDate, $endDate);
        }

        $csvName = 'self_export-test_'.$testId.'-session'.$sessionId.'-'.date('d-m-Y_H:i:s').$tia.'.csv';
        $csvPathExport = $this->kernelRoot.'/data/export/'.$testId.'/';

        $fs->mkdir($csvPathExport, 0777);
        $csvh = fopen($csvPathExport.'/'.$csvName, 'w+');

        fwrite($csvh, $csvContent);
        fclose($csvh);

        return $csvName;
    }

    public function exportSession(Session $session, $startDate = null, $endDate = null)
    {
        $fs = new Filesystem();
        $sessionId = $session->getId();
        $sessionName = preg_replace('#[^a-zàâçéèêëîïôûùüÿñæœ0-9]#i', '_', $session->getname());

        $filename = 'self_export-session'.$sessionName.'-'.date('d-m-Y_H:i:s').'.csv';
        $sessionPathExport = $this->kernelRoot.'/data/session/'.$sessionId.'/';
        $fs->mkdir($sessionPathExport, 0777);
        $csvh = fopen($sessionPathExport.'/'.$filename, 'w+');

        $fileContent = $this->getCsvSessionContent($session, $startDate, $endDate);

        fwrite($csvh, $fileContent);
        fclose($csvh);

        return $filename;
    }

    /**
     * Retourne la liste des fichiers d'export pour un test et un mode donné (csv | pdf).
     */
    public function getFileList(Test $test, $mode)
    {
        if ($mode == 'pdf') {
            $dir = 'exportPdf';
        } else {
            $dir = 'export';
        }

        $testId = $test->getId();
        $csvPathExport = $this->kernelRoot.'/data/'.$dir.'/'.$testId.'/';
        $fileList = array();

        if (is_dir($csvPathExport) && $dossier = opendir($csvPathExport)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $fileList[] = $fichier;
                }
            }
            closedir($dossier);
        }
        arsort($fileList);

        return $fileList;
    }

    /**
     * getCvsContent function
     * Fonction principale pour l'export CSV "classique".
     */
    private function getCsvContent(Test $test, Session $session, $startDate, $endDate)
    {
        $this->startTimer();

        $csv = '';

        $em = $this->entityManager;
        $sessionId = $session->getId();
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test); // 83 questionnaires

        $sessionTraces = $em->getRepository('InnovaSelfBundle:Trace')->findBySession($session); // 35782 traces

        $preprocess = $this->preprocessTest($sessionId, $questionnaires, 'csv', $sessionTraces);
        $propLetters = $preprocess[0];
        $rightProps = $preprocess[1];
        $result = $preprocess[2];
        $csv = $preprocess[3];
        $typology = $preprocess[4];
        $theme = $preprocess[5];

        $users = $em->getRepository('InnovaSelfBundle:User')->findBySessionAndDates($session, $startDate, $endDate); // 790 users

        foreach ($users as $user) {
//            try {
                $this->checkTimer();
//            } catch (ExportTimeoutException $e) {
//            }

            $userId = $user->getId();

            $userTraces = [];

            foreach ($sessionTraces as $k => $trace) {
                if ($trace->getUser() !== $user) {
                    continue;
                }

                $userTraces[] = $trace;
                unset($sessionTraces[$k]);
            }

//            $scores = $this->scoreManager->getScoresFromTraces($traces, false);
//            $score = $this->scoreManager->countCorrectAnswers($scores);

//            $secondStep = $this->getUserSecondStep($session, $user);
//
            $csv .= $this->addColumn($user->getLastName());
            $csv .= $this->addColumn($user->getFirstName());
            $csv .= $this->addColumn(strtolower($user->getMotherTongue()));
            $csv .= $this->addColumn(strtolower($user->getMotherTongueOther()));
            $csv .= $this->addColumn($result[$userId]['date']);
            $csv .= $this->addColumn($result[$userId]['time']);
//            $csv .= $this->addColumn($score);
//            $csv .= $this->addColumn($secondStep);

            foreach ($questionnaires as $questionnaire) {
                $this->checkTimer();

                $questionnaireId = $questionnaire->getId();
                $questions = $questionnaire->getQuestions();
                $typologyName = $typology[$questionnaireId];

                $questionnaireTraces = [];

                foreach ($userTraces as $k => $trace) {
                    if ($trace->getUser() !== $user) {
                        continue;
                    }

                    $questionnaireTraces[] = $trace;
                    unset($userTraces[$k]);
                }

                if (!empty($questionnaireTraces)) {
                    foreach ($questionnaireTraces as $trace) {
                        $this->checkTimer();

                        $csv .= $this->addColumn($theme[$questionnaireId]);
                        $csv .= $this->addColumn($typologyName);
                        $csv .= $this->addColumn($trace->getDifficulty());
                        $csv .= $this->addColumn($trace->getTotalTime());

//                         création tableau de correspondance subquestion -> propositions choisies
                        $answersArray = array();
                        $answers = $trace->getAnswers();

                        foreach ($answers as $answer) {
                            $this->checkTimer();

                            $subquestionId = $answer->getSubquestion()->getId();
                            $answersArray[$subquestionId][] = $answer->getProposition();

                            $this->entityManager->detach($answer);
                            unset($answer);
                        }

//                        // comparaison du tableau créé plus tôt avec le tableau de bonnes propositions
//                        $subquestions = $questions[0]->getSubquestions();
//                        foreach ($subquestions as $subquestion) {
//                            $this->checkTimer();
//
//                            $subquestionId = $subquestion->getId();
//
//                            $csv .= $this->checkRightAnswer($subquestion, $session, $user);
//                            $csv .= $this->textToDisplay($subquestionId, $answersArray, $propLetters, $typologyName);
//
//                            $this->entityManager->detach($subquestion);
//                            unset($subquestion);
//                        }

                        $this->entityManager->detach($trace);
                        unset($trace);
                    }
                } else {
                    if (count($questions) > 0) {
                        $csv .= $this->addColumn('');
                        $csv .= $this->addColumn('');
                        $csv .= $this->addColumn('');
                        $csv .= $this->addColumn('');

                        $subquestions = $questions[0]->getSubquestions();

                        foreach ($subquestions as $subquestion) {
                            $csv .= $this->addColumn('');
                            $csv .= $this->addColumn('');
                        }
                    }
                }
            }

            $csv .= "\n";
        }

        return $csv;
    }

    public function addColumn($text)
    {
        $column = '"'.$text.'"'.';';

        return $column;
    }

    private function checkRightAnswer($subquestion, $session, $user)
    {
        $right = ($this->scoreManager->subquestionCorrect($subquestion, $session, null, $user)) ? 1 : 0;
        $output = $this->addColumn($right);

        return $output;
    }

    private function textToDisplay($subquestionId, $answersArray, $propLetters, $typo)
    {
        $textToDisplay = '';

        switch ($typo) {
            case 'TVF':
            case 'TVFNM':
            case 'TQRU':
            case 'TQRM':
            case 'APP':
                if (isset($answersArray[$subquestionId])) {
                    $letters = array();
                    foreach ($answersArray[$subquestionId] as $answer) {
                        $idAnswer = $answer->getId();
                        $letters[$propLetters[$idAnswer]] = 1;
                    }
                    ksort($letters);
                    foreach ($letters as $key => $value) {
                        $textToDisplay .= $key;
                    }
                }
                break;

            case 'TLCMLDM':
            case 'TLCMLMULT':
            case 'TLQROC':
                if (isset($answersArray[$subquestionId])) {
                    $proposition = $answersArray[$subquestionId][0];
                    $textToDisplay = html_entity_decode($proposition->getMedia()->getDescription());
                }
                break;
        }

        $textToDisplay = $this->addColumn($textToDisplay);

        return $textToDisplay;
    }

    /**
     * getCvsTiaContent function
     * Fonction principale pour l'export CSV "Tia+".
     */
    private function getCsvTiaContent(Test $test, Session $session, $startDate, $endDate)
    {
        $this->startTimer();

        $em = $this->entityManager;
        $sessionId = $session->getId();
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);
        $preprocess = $this->preprocessTest($sessionId, $questionnaires, 'tia');
        $propLetters = $preprocess[0];
        $rightProps = $preprocess[1];
        $csv = $preprocess[3];

        //  BODY
        $users = $em->getRepository('InnovaSelfBundle:User')->findBySessionAndDates($session, $startDate, $endDate);
        foreach ($users as $user) {
            $this->checkTimer();

            $csv .= $user->getLastName().' '.$user->getFirstName().';';
            $csv .= $this->addColumn(strtolower($user->getMotherTongue()));
            $csv .= $this->addColumn(strtolower($user->getMotherTongueOther()));
            $userId = $user->getId();
            $secondStep = $this->getUserSecondStep($session, $user);
            $csv .= $this->addColumn($secondStep);

            foreach ($questionnaires as $questionnaire) {
                $this->checkTimer();

                $questionnaireId = $questionnaire->getId();
                $traces = $em->getRepository('InnovaSelfBundle:Trace')->getByUserAndSessionAndQuestionnaire($userId, $sessionId, $questionnaireId);
                $questions = $questionnaire->getQuestions();
                $typologyName = $questions[0]->getTypology()->getName();

                if ($traces) {
                    foreach ($traces as $trace) {
                        $this->checkTimer();

                        $answers = $trace->getAnswers();
                        $answersArray = array();
                        // création tableau de correspondance Answer --> Subquestion
                        foreach ($answers as $answer) {
                            if (!isset($answersArray[$answer->getProposition()->getSubQuestion()->getId()])) {
                                $answersArray[$answer->getProposition()->getSubQuestion()->getId()] = array();
                            }
                            $answersArray[$answer->getProposition()->getSubQuestion()->getId()][] = $answer->getProposition();
                        }

                        $subquestions = $questions[0]->getSubQuestions();
                        foreach ($subquestions as $subquestion) {
                            $this->checkTimer();

                            $subquestionId = $subquestion->getId();
                            $csv .= $this->checkRightAnswer($subquestion, $session, $user);
                            $csv .= $this->textToDisplay($subquestionId, $answersArray, $propLetters, $typologyName);
                        }
                    }
                } else {
                    if ($questions->count() > 0) {
                        $subquestions = $questions[0]->getSubquestions();
                        foreach ($subquestions as $subquestion) {
                            $csv .= $this->addColumn('');
                            $csv .= $this->addColumn('');
                        }
                    }
                }
            }
            $csv .= "\n";
        }

        $csv .= "\n";
        $csv .= 'Légende :'.';';
        $csv .= "\n";
        $csv .= "première colonne = 1 -> Il s'agit d'une bonne réponse. 0 -> Il s'agit d'une mauvaise réponse".';';
        $csv .= "\n";
        $csv .= "seconde colonne = la réponse tapée/choisie par l'étudiant".';';

        return $csv;
    }

    /**
     * @param int $int
     */
    public function intToLetter($int)
    {
        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F',
        7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', );

        return $arr[$int];
    }

    /**
     * Précalcule pas mal de choses pour éviter les requêtes redondantes plus tard.
     *
     * @param int    $sessionId
     * @param string $mode
     */
    private function preprocessTest($sessionId, $questionnaires, $mode, array $sessionTraces)
    {
        $em = $this->entityManager;
        $propLetters = array();
        $rightProps = array();
        $result = array();
        $cpt_questionnaire = 0;
        $csv = '';
        $typology = array();
        $theme = array();

        if ($mode == 'csv') {
            $csv .= $this->addColumn('Nom');
            $csv .= $this->addColumn('Prénom');
            $csv .= $this->addColumn('Langue maternelle');
            $csv .= $this->addColumn('Autre langue de référence');
            $csv .= $this->addColumn('Date');
            $csv .= $this->addColumn('Temps en secondes (pour le test entier)');
            $csv .= $this->addColumn('Score total obtenu dans le test (formule du total)');
            $csv .= $this->addColumn('Etape de sortie');
        } else {
            $csv .= $this->addColumn('Etudiant');
            $csv .= $this->addColumn('Langue maternelle');
            $csv .= $this->addColumn('Autre langue de référence');
            $csv .= $this->addColumn('Etape de sortie');
        }

        foreach ($questionnaires as $questionnaire) {
            ++$cpt_questionnaire;
            $questionnaireId = $questionnaire->getId();

            $theme[$questionnaireId] = $questionnaire->getTheme();
            $questions = $questionnaire->getQuestions();
            $typology[$questionnaireId] = $questions[0]->getTypology()->getName();

            if ($mode == 'csv') {
                $csv .= $this->addColumn('T'.$cpt_questionnaire.' - NOM de la TACHE');
                $csv .= $this->addColumn('T'.$cpt_questionnaire." - Protocole d'interaction");
                $csv .= $this->addColumn('T'.$cpt_questionnaire.' - difficulté');
                $csv .= $this->addColumn('T'.$cpt_questionnaire.' - TEMPS');
            }

            if (count($questions) > 0) {
                $subquestions = $questions[0]->getSubquestions();
                $cpt = 0;

                foreach ($subquestions as $subquestion) {
                    ++$cpt;
                    $csv .= $this->addColumn($theme[$questionnaireId].' (item '.$cpt.') SCORE (0/1)');
                    $csv .= $this->addColumn($theme[$questionnaireId].' (item '.$cpt.') PROPOSITION');
                }
            }

            $traces = [];

            foreach ($sessionTraces as $k => $trace) {
                if ($trace->getQuestionnaire() !== $questionnaire) {
                    continue;
                }

                $traces[] = $trace;
                unset($sessionTraces[$k]);
            }

            foreach ($traces as $trace) {
                $userId = $trace->getUser()->getId();

                if (!isset($result[$userId]['time'])) {
                    $result[$userId]['time'] = 0;
                }

                $result[$userId]['time'] = $result[$userId]['time'] + $trace->getTotalTime();
                $result[$userId]['name'] = (string) $trace->getUser();
                $result[$userId]['date'] = date_format($trace->getDate(), 'dm');

                $this->entityManager->detach($trace);
            }

            foreach ($questions as $question) {
                $typologyName = $question->getTypology()->getName();
                $subquestions = $question->getSubquestions();

                foreach ($subquestions as $subquestion) {
                    $rightProps['sub'.$subquestion->getId()] = array();
                    $cptProposition = 0;
                    $propositions = $subquestion->getPropositions();

                    foreach ($propositions as $proposition) {
                        ++$cptProposition;

                        if ($typologyName != 'TLQROC') {
                            $propLetters[$proposition->getId()] = $this->intToLetter($cptProposition);
                        }

                        if ($proposition->getRightAnswer()) {
                            $rightProps['sub'.$subquestion->getId()][] = $proposition->getId();
                        }
                    }
                }
            }
        }

        $csv .= "\n";

        return array($propLetters, $rightProps, $result, $csv, $typology, $theme);
    }

    private function getCsvSessionContent(Session $session, $startDate, $endDate)
    {
        $format = 'Y-m-d H:i:s';
        $csv = '';
        $em = $this->entityManager;

        if ($startDate === null || $startDate === "") {
            $startDate = date_create_from_format($format, '1970-01-01 00:00:00');
        } else {
            $startDate = date_create_from_format($format, $startDate);
        }

        if ($endDate === null || $endDate === "") {
            $endDate = date($format);
        } else {
            $endDate = date_create_from_format($format, $endDate);
        }

        $users = $em->getRepository('InnovaSelfBundle:User')->findBySessionAndDates($session, $startDate, $endDate);

        $csv .= $this->addColumn($session->getTest()->getName());
        $csv .= $this->addColumn($session->getName());

        $csv .= "\n";

        $csv .= $this->addColumn("Nom d'utilisateur");
        $csv .= $this->addColumn('Nom');
        $csv .= $this->addColumn('Prénom');
        $csv .= $this->addColumn('Email');
        $csv .= $this->addColumn('Etablissement');
        $csv .= $this->addColumn('Filière');
        $csv .= $this->addColumn('Spécialité');
        $csv .= $this->addColumn('Année');
        $csv .= $this->addColumn('Début');
        $csv .= $this->addColumn('Durée totale');
        $csv .= $this->addColumn('Score agrégé');
        $csv .= $this->addColumn('Score CO');
        $csv .= $this->addColumn('Score CE');
        $csv .= $this->addColumn('Score EEC');
        $csv .= $this->addColumn('Test fini');
        $csv .= $this->addColumn('Langue maternelle');
        $csv .= $this->addColumn('Autre langue de référence');

        $csv .= "\n";

        foreach ($users as $user) {
            $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user, 'test' => $session->getTest(), 'session' => $session));
            $csv .= $this->addColumn($user->getUsername());
            $csv .= $this->addColumn($user->getLastName());
            $csv .= $this->addColumn($user->getFirstName());
            $csv .= $this->addColumn($user->getEmail());

            $institution = ($user->getInstitution()) ? $user->getInstitution()->getName() : '';
            $course = ($user->getCourse()) ? $user->getCourse()->getName() : '';
            $subcourse = ($user->getSubCourse()) ? $user->getSubCourse()->getName() : '';
            $year = ($user->getYear()) ? $user->getYear()->getName() : '';
            $registeredScore = $em->getRepository('InnovaSelfBundle:UserResult')->findOneBy(array('user' => $user, 'session' => $session));

            $isTestFinished = $registeredScore ? true : $this->isTestFinished($traces);
            $saveScore = ($isTestFinished && !$registeredScore) ? true : false;

            $scoreGlobal = $registeredScore
                ? $registeredScore->getGeneralScore()
                : $this->scoreManager->getGlobalScore($session, $user, $saveScore);

            $scoreCO = $registeredScore
                ? $registeredScore->getCoScore()
                : $this->scoreManager->getSkillScore($session, $user, 'CO', $saveScore);

            $scoreCE = $registeredScore
                ? $registeredScore->getCeScore()
                : $this->scoreManager->getSkillScore($session, $user, 'CE', $saveScore);

            $scoreEEC = $registeredScore
                ? $registeredScore->getEecScore()
                : $this->scoreManager->getSkillScore($session, $user, 'EEC', $saveScore);

            $lastTrace = end($traces)->getDate();
            $firstTrace = reset($traces)->getDate();

            $csv .= $this->addColumn($institution);
            $csv .= $this->addColumn($course);
            $csv .= $this->addColumn($subcourse);
            $csv .= $this->addColumn($year);
            $csv .= $this->addColumn($firstTrace->format('d-m-Y H:i:s'));
            $csv .= $this->addColumn($this->minutesDiff($firstTrace, $lastTrace));
            $csv .= $this->addColumn($scoreGlobal);
            $csv .= $this->addColumn($scoreCO);
            $csv .= $this->addColumn($scoreCE);
            $csv .= $this->addColumn($scoreEEC);
            $csv .= $this->addColumn($isTestFinished ? 'oui' : 'non');

            $csv .= $this->addColumn(strtolower($user->getMotherTongue()));
            $csv .= $this->addColumn(strtolower($user->getMotherTongueOther()));

            $csv .= "\n";
        }

        $csv .= "\n";

        return $csv;
    }

    private function isTestFinished($traces)
    {
        $lastTrace = end($traces);
        $lastComponent = $lastTrace->getComponent();
        $test = $lastTrace->getTest();

        if ($test->getPhased() && $lastComponent->getComponentType()->getName() == 'minitest') {
            return false;
        }

        $expectedTracesCount = ($test->getPhased())
            ? count($lastTrace->getComponent()->getOrderQuestionnaireComponents()) + count($lastTrace->getComponent()->getOrderQuestionnaireComponents())
            : count($test->getOrderQuestionnaireTests());

        if (count($traces) < $expectedTracesCount) {
            return false;
        }

        return true;
    }

    private function minutesDiff(\DateTime $startTime, \DateTime $endTime)
    {
        $interval = $startTime->diff($endTime);

        $minutes = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;

        return $minutes;
    }

    private function humanDiff(\DateTime $startTime, \DateTime $endTime)
    {
        $interval = $startTime->diff($endTime);

        $humanInterval = '';

        if ($interval->y > 0) {
            $humanInterval = $interval->y . 'année' . ($interval->y > 1 ? 's' : '')  . ' ';
        }

        if ($interval->m > 0) {
            $humanInterval = $humanInterval .$interval->m . ' mois' . ' ';
        }

        if ($interval->d > 0) {
            $humanInterval = $humanInterval .$interval->d . ' jour' . ($interval->d > 1 ? 's' : '') . ' ';
        }

        if ($interval->h > 0) {
            $humanInterval = $humanInterval .$interval->h . ' heure' . ($interval->h > 1 ? 's' : '') . ' ';
        }

        if ($interval->i > 0) {
            $humanInterval = $humanInterval .$interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ';
        }

        if ($interval->s > 0) {
            $humanInterval = $humanInterval . $interval->s . ' seconde' . ($interval->s > 1 ? 's' : '');
        }

        return $humanInterval;
    }

    // Solution temporaire pour bloquer l'export si trop long sans planter l'app

    private function startTimer()
    {
        $this->execStartedAt = microtime(true);
    }

    private function checkTimer()
    {
        $elapsedExecTime = microtime(true) - $this->execStartedAt;

        if ($elapsedExecTime > $this->execTimeLimit) {
            throw new ExportTimeoutException();
        }
    }
}
