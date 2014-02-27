<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Form\TestType;
use Innova\SelfBundle\Entity\Typology;

class TestController extends Controller
{

    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     *
     * @Route("student/test/start/{id}", name="test_start")
     * @Method("GET")
     * @Template()
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

        return array(
            'questionnaire' => $questionnaire,
            'language' => $languageColor,
            'test' => $test,
            'counQuestionnaireDone' => $countQuestionnaireDone,
        );
    }

     /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     *
     * @Route("/test_end/{id}", name="test_end")
     * @Template()
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
     * Lists all Test entities.
     *
     * @Route("admin/test", name="test")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Test entities.
     *
     * @Route("student/test/user", name="user_test")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function userIndexAction()
    {

        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        // Par défaut pour la V1, on crée le premier test quand un utilisateur est nouveau
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        // TODO
        $test = $tests[0];

        if (!$test) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        // If the user doesn't have any test, then I add one test in 'user_test 'table.
        if (count($user->getTests()) === 0) {
            $user->addTest($test);
            $em->persist($user);
            $em->flush();
        }

        // Redirection vers la page de démarrage du test.
        return $this->redirect(
            $this->generateUrl(
                'test_start',
                array('id' => $test->getId()
                )
            )
        );
    }

    /**
     * Creates a new Test entity.
     *
     * @Route("admin/test", name="test_create")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Test:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Test();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'test_show',
                    array(
                        'id' => $entity->getId()
                    )
                )
            );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Test entity.
    *
    * @param Test $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Test $entity)
    {
        $form = $this->createForm(
            new TestType(),
            $entity,
            array(
            'action' => $this->generateUrl('test_create'),
            'method' => 'POST',
            )
        );

        $form->add(
            'submit',
            array('label' => 'Create')
        );

        return $form;
    }

    /**
     * Displays a form to create a new Test entity.
     *
     * @Route("admin/test/new", name="test_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Test();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Test entity.
     *
     * @Route("admin/test/{id}", name="test_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Test entity.
     *
     * @Route("admin/test/{id}/edit", name="test_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Test entity.
    *
    * @param Test $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Test $entity)
    {
        $form = $this->createForm(
            new TestType(),
            $entity,
            array(
            'action' => $this->generateUrl('test_update', array('id' => $entity->getId())),
            'method' => 'PUT',
           )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Test entity.
     *
     * @Route("admin/test/{id}", name="test_update")
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Test:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('test_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Test entity.
     *
     * @Route("admin/test/{id}", name="test_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InnovaSelfBundle:Test')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Test entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('test'));
    }

    /**
     * Creates a form to delete a Test entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('test_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * exportCsvSQL function
     * Update : 16/10/2013 by EV email Cristiana
     *
     * @Route(
     *     "/admin/csv",
     *     name = "csv_export",
     *     options = {"expose"=true}
     * )
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function exportCsvSQLAction()
    {
        $em = $this->getDoctrine()->getManager();

        //
        // CSV Export part
        //

        // File export path
        $csvPathExport =__DIR__.'/../../../../web/upload/export/csv/'; // Symfony

        // File export name
        $csvName = 'export-' . date("Ymd_d-m-Y_H:i:s") . '.csv';

        // Symfony
        $urlCSVRelativeToWeb = 'upload/export/csv/';

        // Path + Name
        $csvPath = $csvPathExport . $csvName;

        // Open file
        $csvh = fopen($csvPath, 'w+');

        // Init csv write variable
        $csv = '';

        // Loop for test
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        $result = array();

        foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                // For THE questionnaire, loop on the Trace
                $traces = $questionnaire->getTraces();
                foreach ($traces as $trace) {
                    $userName  = (string) $trace->getUser();
                    $emailName = (string) $trace->getUser()->getEmail();
                    $testDate  = date_format($trace->getDate(), 'd-m-Y');
                    if (!isset($result[$userName]["time"])) {
                        $result[$userName]["time"]=0;
                    }
                    $result[$userName]["time"] = $result[$userName]["time"] + $trace->getTotalTime();
                    $result[$userName]["name"]  = $userName;
                    $result[$userName]["email"] = $emailName;
                    $result[$userName]["date"]  = $testDate;
                }
            }
        }

        $csv .= "\n";
        //$csv .= "\n";

        // Difficulty part
        $csv .= "Difficulté" . ";" ;
        $csv .= "Libellé" . ";" ;
        $csv .= "\n";
        $csv .= "1" . ";" ;
        $csv .= "Très facile" . ";" ;
        $csv .= "\n";
        $csv .= "2" . ";" ;
        $csv .= "Facile" . ";" ;
        $csv .= "\n";
        $csv .= "3" . ";" ;
        $csv .= "Normal" . ";" ;
        $csv .= "\n";
        $csv .= "4" . ";" ;
        $csv .= "Difficile" . ";" ;
        $csv .= "\n";
        $csv .= "5" . ";" ;
        $csv .= "Très Difficile" . ";" ;
        $csv .= "\n";

        $csv .= "\n";
        $csv .= "\n";

        // HEADER
        // Loop to display all questionnaire of the test
        $csv .= "Mail;" ; // A
        $csv .= "NOM;" ; // B
        $csv .= "Prénom;" ; // C
        $csv .= "Date;" ; // D
        $csv .= "tpstot;" ; // E

        $csv .= "filiere;" ; // F
        $csv .= "nivlans;" ; // G
        $csv .= "dialco;" ; // H
        $csv .= "dialce;" ; // I
        $csv .= "dialee;" ; // J

        $cpt_questionnaire=0;
        foreach ($tests as $test) {
            if ($cpt_questionnaire == 0) {
                $questionnaires = $test->getQuestionnaires();
                // For THE test, loop on the Questionnaire
                foreach ($questionnaires as $questionnaire) {
                    $cpt_questionnaire++;
                    // Suite réception nouvelle version du fichier le 29/11/2013 :
                    // je prends le dernier ou les 2 derniers caractères du thême
                    $themeCode = substr($questionnaire->getTheme(), -2);
                    // Si l'extrait est numérique, alors OK
                    // sinon, je ne prends que le dernier caractère.
                    // Exemple : A1COT2, je prends le dernier
                    // A1COT13, je prends les 2 derniers.
                    //
                    if (!is_numeric($themeCode)) {
                        $themeCode = substr($questionnaire->getTheme(), -1);
                    }
                    $csv .= $questionnaire->getTheme() . ";";
                    $csv .= "t" . $themeCode . "diff;";
                    $csv .= "t" . $themeCode . "tps;";
                    $questions = $questionnaire->getQuestions();
                    foreach ($questions as $question) {
                        $subquestions = $question->getSubQuestions();
                        $cpt=0;
                        foreach ($subquestions as $subquestion) {
                            $cpt++;
                            $csv .= "t" . $themeCode . "res" . $cpt . ";"; // Ajout d'une colonne pour chaque proposition de la question.
                            $csv .= "t" . $themeCode . "ch" . $cpt . ";";
                        }
                    }
                }
            }
        }

        $csv .= "\n";

        // BODY
        // Loop to display all data
        foreach ($tests as $test) {
            $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
            foreach ($users as $user) {
                $csv .= $user->getEmail() . ";" ;
                $csv .= $user->getUserName() . ";" ;
                $csv .= $user->getFirstName() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
                //
                $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                    ->countDoneYetByUserByTest($test->getId(), $user->getId());

                if ($countQuestionnaireDone > 0) {
                    $csv .= $result[$user->getUserName()]["date"] . ";" . $result[$user->getUserName()]["time"] . ";";
                    // Add 5 colums for Level
                    //
                    /*$csv .= $user->getStudentType() . ";";
                    $csv .= $user->getLastLevel() . ";";
                    $csv .= $user->getCoLevel() . ";";
                    $csv .= $user->getCeLevel() . ";";
                    $csv .= $user->getEeLevel() . ";";*/
                    //
                    $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();
                    foreach ($questionnaires as $questionnaire) {

                        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user->getId(),
                                        'questionnaire' => $questionnaire->getId()
                                        )
                                    );

                        foreach ($traces as $trace) {
                            $answers = $trace->getAnswers();
                            $csv .= ";" ;

                            $csv .= $trace->getDifficulty() . ";" ;
                            $csv .= $trace->getTotalTime() . ";" ;

                            foreach ($answers as $answer) {
                                $propositions = $answer->getProposition()->getSubQuestion()->getPropositions();
                                $cptProposition = 0;
                                foreach ($propositions as $proposition) {
                                    $cptProposition++;
                                    if ($proposition->getId() === $answer->getProposition()->getId()) {
                                        $propositionRank = $cptProposition;
                                    }
                                }
                                $csv .= ($answer->getProposition()->getRightAnswer() ? '1' : '0') . ";";

                                if ($answer->getProposition()->getTitle() != "") {
                                    $csv .= $answer->getProposition()->getTitle() . ";";
                                } else {
                                    $csv .= $propositionRank . ";";
                                }
                            }
                        }
                    }
                }
                $csv .= "\n";

            }
        }
        // FOOTER
        // Empty

        fwrite($csvh, $csv);
        fclose($csvh);

        //
        // Export file list
        //
        $fileList = array();
        $nbFile = 0;
        if ($dossier = opendir($csvPathExport)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $nbFile++; // Number of files + 1
                    $fileList[$nbFile] = $fichier;
                }
            }
        }

        closedir($dossier); // Directory close

        //Sort file
        arsort($fileList);

        //
        // To view
        //
        return array(
            "urlCSVRelativeToWeb" => $urlCSVRelativeToWeb,
            "csvName"             => $csvName,
            "fileList"            => $fileList,
            "nbFile"              => $nbFile
        );
    }

    /**
     * importCsvSQL function
     *
     * @Route(
     *     "/admin/csv-import",
     *     name = "csv-import"
     * )
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function importCsvSQLAction()
    {
        $em = $this->getDoctrine()->getManager();

       //
        // CSV Import part
        //

        // File import path
        $csvPathImport    =__DIR__.'/../../../../web/upload/import/test-csv/'; // Symfony
        $csvPathImportMp3 =__DIR__.'/../../../../web/upload/import/test-mp3/'; // Symfony

        // File import name
        $csvName = 'test.csv'; // Suite réception MP.

        // Symfony
        $urlCSVRelativeToWeb = 'upload/import/csv/';
        // Path + Name:wq
        $csvPath = $csvPathImport . $csvName;

        // File import path
        // Répertoire où seront stockés les fichiers
        $dir2copy =__DIR__.'/../../../../web/upload/import/test-mp3/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        $dir_paste =__DIR__.'/../../../../web/upload/media/'; // A modifier quand on aura l'adresse

// Traitement des fichiers reçus
// DEBUT
//
        if ($dossier = opendir($csvPathImportMp3)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && is_file($csvPathImportMp3.$fichier)) {

                    $exp = explode("_", $fichier);

                    $exp[0] = strtolower($exp[0]);
                    if (isset($exp[1])) {
                        $exp[1] = strtolower($exp[1]);
                    }
                    if (isset($exp[2])) {
                        $exp[2] = strtolower($exp[2]);
                    }
                    if (isset($exp[3])) {
                        $exp[3] = strtolower($exp[3]);
                    }
                    if (isset($exp[4])) {
                        $exp[4] = strtolower($exp[4]);
                    }
                    if (isset($exp[5])) {
                        $exp[5] = strtolower($exp[5]);
                    }
                    if (isset($exp[6])) {
                        $exp[6] = strtolower($exp[6]);
                    }
                    if (isset($exp[7])) {
                        $exp[7] = strtolower($exp[7]);
                    }
                    //$repertoryName = strtolower($exp[0]);

                    $indice_fileName = 0;
                    if (isset($exp[0])) {
                        if ((preg_match("/consigne/i", $exp[0])) || (preg_match("/option/i", $exp[0]))
                        || (preg_match("/contexte/i", $exp[0])) || (preg_match("/texte/i", $exp[0]))
                        || (preg_match("/amorce/i", $exp[0])) || (preg_match("/reponse/i", $exp[0]))) {
                            $indice_fileName = 0;
                        }

                        else
                        {
                            $repertoryName = strtolower($exp[0]);
                        }
                    }

                    if (isset($exp[1])) {
                        if ((preg_match("/consigne/i", $exp[1])) || (preg_match("/option/i", $exp[1]))
                        || (preg_match("/contexte/i", $exp[1])) || (preg_match("/texte/i", $exp[1]))
                        || (preg_match("/amorce/i", $exp[1])) || (preg_match("/reponse/i", $exp[1]))) {
                            $indice_fileName = 1;
                        }
                        else
                        {
                            $repertoryName .=  "_" . strtolower($exp[1]);
                        }
                    }

                    if (isset($exp[2])) {
                        if ((preg_match("/consigne/i", $exp[2])) || (preg_match("/option/i", $exp[2]))
                        || (preg_match("/contexte/i", $exp[2])) || (preg_match("/texte/i", $exp[2]))
                        || (preg_match("/amorce/i", $exp[2])) || (preg_match("/reponse/i", $exp[2]))) {
                            $indice_fileName = 2;
                        }
                        else
                        {
                            $repertoryName .=  "_" .  strtolower($exp[2]);
                        }
                    }

                    if (isset($exp[3])) {
                        if ((preg_match("/consigne/i", $exp[3])) || (preg_match("/option/i", $exp[3]))
                        || (preg_match("/contexte/i", $exp[3])) || (preg_match("/texte/i", $exp[3]))
                        || (preg_match("/amorce/i", $exp[3])) || (preg_match("/reponse/i", $exp[3]))) {
                            $indice_fileName = 3;
                        }
                        else
                        {
                            if (!preg_match("/mp3/i", $exp[3]) && !preg_match("/jpg/i", $exp[3]) && !preg_match("/flv/i", $exp[3])) {
                                $repertoryName .=   "_" . strtolower($exp[3]);
                            }
                        }
                    }

                    if ($indice_fileName == 0 ) {
                        if (isset($exp[4])) {
                            if ((preg_match("/consigne/i", $exp[4])) || (preg_match("/option/i", $exp[4]))
                            || (preg_match("/contexte/i", $exp[4])) || (preg_match("/texte/i", $exp[4]))
                            || (preg_match("/amorce/i", $exp[4])) || (preg_match("/reponse/i", $exp[4]))) {
                                $indice_fileName = 4;
                            }
                            else
                            {
                                if (!preg_match("/mp3/i", $exp[4]) && !preg_match("/jpg/i", $exp[4]) && !preg_match("/flv/i", $exp[4])) {
                                    $repertoryName .=   "_" . strtolower($exp[4]);
                                }
                            }
                        }
                    }

                    if ($indice_fileName == 0 ) {
                        if (isset($exp[5])) {
                            if ((preg_match("/consigne/i", $exp[5])) || (preg_match("/option/i", $exp[5]))
                            || (preg_match("/contexte/i", $exp[5])) || (preg_match("/texte/i", $exp[5]))
                            || (preg_match("/amorce/i", $exp[5])) || (preg_match("/reponse/i", $exp[5]))) {
                                $indice_fileName = 5;
                            }
                            else
                            {
                                if (!preg_match("/mp3/i", $exp[5]) && !preg_match("/jpg/i", $exp[5]) && !preg_match("/flv/i", $exp[5])) {
                                    $repertoryName .= "_" . strtolower($exp[5]);
                                }
                            }
                        }
                    }

                    if ($indice_fileName == 0 ) {
                        if (isset($exp[6])) {
                            if ((preg_match("/consigne/i", $exp[6])) || (preg_match("/option/i", $exp[6]))
                            || (preg_match("/contexte/i", $exp[6])) || (preg_match("/texte/i", $exp[6]))
                            || (preg_match("/amorce/i", $exp[6])) || (preg_match("/reponse/i", $exp[6]))) {
                                $indice_fileName = 6;
                            }
                            else
                            {
                                if (!preg_match("/mp3/i", $exp[6]) && !preg_match("/jpg/i", $exp[6]) && !preg_match("/flv/i", $exp[6])) {
                                    $repertoryName .= "_" . strtolower($exp[6]);
                                }
                            }
                        }
                    }

                    if ($indice_fileName == 0 ) {
                        if (isset($exp[7])) {
                            if ((preg_match("/consigne/i", $exp[7])) || (preg_match("/option/i", $exp[7]))
                            || (preg_match("/contexte/i", $exp[7])) || (preg_match("/texte/i", $exp[7]))
                            || (preg_match("/amorce/i", $exp[7])) || (preg_match("/reponse/i", $exp[7]))) {
                                $indice_fileName = 7;
                            }
                            else
                            {
                                if (!preg_match("/mp3/i", $exp[7]) && !preg_match("/jpg/i", $exp[7]) && !preg_match("/flv/i", $exp[7])) {
                                    $repertoryName .= "_" . strtolower($exp[7]);
                                }
                            }
                        }
                    }


                    $fileName = $exp[$indice_fileName]; // = nom de l'option : amorce/consigne/contexte/texte

                    if (preg_match("/mp3/i", $exp[$indice_fileName])) {
                        $nb = explode(".", $exp[$indice_fileName]);
                        $fileName = $nb[0];
                    }



                    $repertoryMkDir = $csvPathImportMp3 . $repertoryName;
                    // Création du répertoire (s'il n'est pas déjà créé)
                    if(!is_dir($repertoryMkDir)) mkdir ($repertoryMkDir, 0777);

                    echo "## creation repertoire : ".$repertoryName."<br/>";
                    $number = $indice_fileName+1;

                    $nb[0] = null;
                    if (isset($exp[$number])) {
                        $nb = explode(".", $exp[$number]);
                        if (($nb[0] == '1') || ($nb[0] == '2') || ($nb[0] == '3')  || ($nb[0] == '4') || ($nb[0] == '5')) {
                            $fileName .= $nb[0];
                            $numberExist = true;
                        }
                        $number++;
                        if (isset($exp[$number])) {
                            $fileName = $fileName . "_" . $exp[$number];
                        }
                    }
                    else
                    {
                        $nb = explode(".", $fileName);
                        $fileName = $nb[0];
                        $numberExist = false;
                    }

                    // Extension
                    $fileExtension = explode(".", $fichier);
                    $extension = $fileExtension[1];

                    // Fin traitement extension

                    if (preg_match("/option/i", $fileName)) {
                        if ($numberExist) {
                            if (isset($exp[$number])) {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_". $nb[0] . "_" . $exp[$number]);
                            }
                            else
                            {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_". $nb[0] . "." . $extension);
                            }
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option." . $extension);
                        }
                    }

                    if (preg_match("/reponse/i", $fileName)) {
                        if ($numberExist) {
                            if (isset($exp[$number])) {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/reponse_". $nb[0] . "_" . $exp[$number]);
                            }
                            else
                            {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/reponse_". $nb[0] . "." . $extension);
                            }
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/reponse." . $extension);
                        }
                    }

/*
                    // Traitement de la partie "option".
                    if (preg_match("/option/i", $fileName)) {
                        // Ajout 13/12/2013 : traitement du cas TQRU.
                        // Les fichiers "option" sont nommés par exemple <XXX_option_1_1.mp3>
                        // alors que dans les autres cas, ils sont de type <XXX_option_1.mp3>
                        // #118
                        if (!is_numeric($exp[2])) {
                            $number = explode(".", $exp[2]);
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_" . $number[0] . ".mp3");
                        } else {
                            $number = explode(".", $exp[3]);
                            $number = $number[0];
                            if (!is_numeric($number)) {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_" . $exp[2] . ".mp3");
                            } else {
                                copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_" . $exp[2] . "_" . $number . ".mp3");
                            }

                        }
                    }
*/
                    if (preg_match("/amorce/i", $fileName)) {
                        if ($numberExist) {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/amorce_". $nb[0] . ".mp3");
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/amorce.mp3");
                        }
                    }

                    if (preg_match("/consigne/i", $fileName)) {
                        if ($numberExist) {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/consigne_". $nb[0] . ".mp3");
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/consigne.mp3");
                        }
                    }

                    // Ajout de ^ pour le test uniquement sur texte.
                    if (preg_match("/^texte/i", $fileName)) {
                        if ($numberExist) {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/texte_". $nb[0] . "." . $extension);
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/texte." . $extension);
                        }
                    }

                    if (preg_match("/contexte/i", $fileName)) {
                        if ($numberExist) {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/contexte_". $nb[0] . ".mp3");
                        }
                        else
                        {
                            copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/contexte.mp3");
                        }
                    }
                }
            }

        }
// FIN
//

        echo "<br/> ************  TRAITEMENT CSV ************<br/>";
        // Traitement du fichier d'entrée afin de ne pas prendre la ou les premières lignes.
        // Contrainte : dans la colonne "A", il faut une donnée de type "entier" séquentielle (1 puis 2 ...)
        // Cette contrainte a été prise en compte par rapport au fichier reçu.
        $row = 0;
        $indice = 0;

        if (($handle = fopen($csvPath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 2000, ";")) !== FALSE) {
                // Ainsi, je ne prends pas les intitulés des colonnes
                if ($row != 0) {
                    //
                    //
                    // Première partie : ajout dans la table Questionnaire
                    //
                    //

                    // Add to Questionnaire table
                    $questionnaire = new Questionnaire();
                    $language = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Italian");
                    $testName = "test-english"; // For tests.
                    $testName = "SELF CO Italien ko-26-02"; // For tests.

//                    if (!$test =  $em->getRepository('InnovaSelfBundle:Test')->findOneByName($testName)) {
                    if ($row == 1) {
                        $test = new Test();
                        $test->setName($testName);
                        $test->setLanguage($language);
                        $em->persist($test);
                    }

                    $questionnaire->addTest($test);
                    //
                    // J'ai traité les colonnes de la table Questionnaire dans l'ordre
                    //
                    //
                    //
                    //
                    $data[1] = strtolower($data[1]); // Mise en minuscules du nom du fichier suite aux tests.

                    // Traitement sur le level
                    $libLevel = $data[2];
                    $level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($libLevel);
                    $questionnaire->setLevel($level);

                    // Traitement sur le skill
                    $libSkill = $data[3];
                    $skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($libSkill);
                    $questionnaire->setSkill($skill);

                    // Traitement sur la typologie
                    $libTypo = $data[4];
                    $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypo);

                    // Traitement des autres colonnes
                    $questionnaire->setAuthor();
                    $questionnaire->setInstruction();
                    $questionnaire->setSource();
                    $questionnaire->setDuration();
                    $questionnaire->setDomain();
                    $questionnaire->setSupport();
                    $questionnaire->setFlow();
                    $questionnaire->setFocus();
                    $questionnaire->setTheme($data[1]); // Thême
                    echo "## creation questionnaire : ".$data[1]."<br/>";

                    //Dialogue
                    $questionnaire->setDialogue(0);
                    // Vu avec Arnaud : 1 pour Dialogue / 0 pour Monologue
                    $libDialogue = $data[8];
                    $pos = strripos($libDialogue, 'dialogue');

                    if ($pos === false) {
                        $pos = strripos($libDialogue, 'monologue');
                        if (!($pos === false)) {
                            $questionnaire->setDialogue(0);
                        }
                    } else {
                        $questionnaire->setDialogue(1);
                    }

                    //ListeningLimit
                    $questionnaire->setListeningLimit($data[9]);

                    //Autres colonnes
                    $questionnaire->setMediaInstruction();
                    $questionnaire->setMediaContext();
                    $questionnaire->setMediaText();

                    $indice++;
                    $data[4] = trim($data[4]);
                    $data[12] = trim($data[12]);
                    // Enregistrement en base
                    $em->persist($questionnaire);

                    //
                    //
                    // Deuxième partie : traitement des fichiers de type "Media"
                    //
                    //
                    // $data[1]  = nom du répertoire = nom du thême
                    // $data[10] = nom de l'extension du fichier (ex : mp3)
                    $data[1] = trim($data[1]);
                    $this->copieFileDir($data[1], $data[10], $questionnaire, $dir2copy, $dir_paste);

                    //
                    //
                    // Troisième partie : travail sur les types TQRM et TQRU
                    //
                    //

                    // Traitement suivi le type de questionnaire.
                    switch ($data[4]) {
                        case "TQRU";
                        case "TQRM";
                            $this->tqrProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "QRU";
                        case "QRM";
                            $this->qrProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "TVF";
                        case "VF";
                        case "VFPM";
                        case "TVFPM";
                            $this->vfProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "TVFNM";
                            $this->tvfnmProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAT";
                            $this->appatProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "QRU_I";
                            $this->qruiProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAA";
                            $this->appaaProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAI";
                            $this->appaiProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                    }

                    $em->flush();
                }
                $row++;
            }
            fclose($handle);
        }
        //SOX. To execute shell SOX command to have Ogg files. 13/01/2014.
        //shell_exec(__DIR__.'/../../../../import/import.sh > ' . __DIR__ . '/../../../../import/logs/import.log');
die();

        //
        // To view
        //
        return array(
            "urlCSVRelativeToWeb" => $urlCSVRelativeToWeb,
            "csvName"             => $csvName
        );
    }

    /**
     * appaiProcess function
     *
     */
    private function appaiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        $medias = array();
        $this->mediaAppaiPropositionProcess($data[1], $medias, $dir2copy, $dir_paste);

        $nbItems = $data[11];
        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaiSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            $nbMedias = count($medias); #80
            for ($j = 0; $j <  $nbMedias; $j++) {
                $this->propositionAppaiProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaiPropositionProcess function
     *
     */
    private function mediaAppaiPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        $i = 1;

        while (file_exists($dir2copy . $dirName . "/reponse_" . $i . ".jpg")) {
            $media = new Media();
            $media->setName($dirName . "_reponse_" . $i);
            $media->setUrl($dirName . "_reponse_" . $i . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image"));

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($dir2copy . $dirName . "/reponse_" . $i . ".jpg", $dir_paste . $fileCopy . ".jpg");

            $medias[] = $media;
            $i++;
        }
    }

    /**
     * mediaAppaiSubQuestionProcess function
     *
     */
    private function mediaAppaiSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, Subquestion $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        $indice = $i+1;

        $testFile = $dir2copy . $dirName . "/option_" . $indice . ".mp3";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_option_" . $indice);
            $media->setUrl($dirName . "_option_" . $indice . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            $subQuestion->setMedia($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($testFile, $dir_paste . $fileCopy . ".mp3");
        }
    }

    /**
     * propositionAppaaProcess function
     *
     */
    private function propositionAppaiProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * appaProcess function
     *
     */
    private function appaaProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        $medias = array();
        $this->mediaAppaaPropositionProcess($data[1], $medias, $dir2copy, $dir_paste);

        $nbItems = $data[11];
        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaaSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            $nbMedias = count($medias); #80
            for ($j = 0; $j < $nbMedias; $j++) {
                $this->propositionAppaaProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaaSubQuestionProcess function
     *
     */
    private function mediaAppaaSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, Subquestion $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        $indice = $i+1;
        $testFile = $dir2copy . $dirName . "/option_" . $indice . ".mp3";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_option_" . $indice);
            $media->setUrl($dirName . "_option_" . $indice . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            $subQuestion->setMedia($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($testFile, $dir_paste . $fileCopy . ".mp3");
        }
    }

    /**
     * mediaAppaaPropositionProcess function
     *
     */
    private function mediaAppaaPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        $i = 1;

        while (file_exists($dir2copy . $dirName . "/reponse_" . $i . ".mp3")) {
            $media = new Media();
            $media->setName($dirName . "_reponse_" . $i);
            $media->setUrl($dirName . "_reponse_" . $i . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($dir2copy . $dirName . "/reponse_" . $i . ".mp3", $dir_paste . $fileCopy . ".mp3");

            $medias[] = $media;
            $i++;
        }
    }

    /**
     * propositionAppaaProcess function
     *
     */
    private function propositionAppaaProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * copieFileDir function
     *
     */
    //#77
    private function copieFileDir($mediaDir, $itemExtention, Questionnaire $questionnaire, $dir2copy, $dir_paste)
    {

        $em = $this->getDoctrine()->getManager();

        // File import path
        // Répertoire où seront stockés les fichiers
        //$dir2copy =__DIR__.'/../../../../web/upload/test_eric/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        //$dir_paste =__DIR__.'/../../../../web/upload/test_eric/media/'; // A modifier quand on aura l'adresse

        if (is_dir($dir2copy)) {
            // Si oui, on l'ouvre
            if ($dh = opendir($dir2copy)) {
                $filesToCopy = array('consigne', 'texte', 'contexte');
                // Consigne = audio
                // Item = cf Excel
                // Contexte = audio
                foreach ($filesToCopy as $fichier) {

                    if ($fichier != 'texte') {
                        $newItemExtention = "mp3";
                    } else {
                         $newItemExtention = $itemExtention;
                    }

                    // Recherche si le fichier existe
                    // S'il n'existe pas, je passe au suivant.
                    //
                    $testFile = $dir2copy . $mediaDir . '/' . $fichier . "." . $newItemExtention;

                    if (file_exists($testFile)) {
                        // Création dans "Media"
                        $media = new Media();
                        $media->setName($mediaDir . "_" . $fichier);
                        $media->setUrl($mediaDir . "_" . $fichier . "_" . uniqid());

                        // Tableau d'extension
                        $aMedia["label"] = array("audio", "video");
                        $aMedia["extension"][0] = array('mp3');
                        $aMedia["extension"][1] = array('flv', 'mp4');

                        // Traitement suivant le type de fichier.
                        if ($fichier != 'texte') {
                            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                        } else {
                            foreach ($aMedia["extension"] as $key => $value) {
                                if (in_array($newItemExtention, $value)) {
                                    $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($aMedia["label"][$key]);
                                }
                            }
                        }
                        $media->setMediaType($mediaType);

                        // Enregistrement en base
                        $em->persist($media);

                        // Copie du fichier
                        $fileCopy = $media->getUrl();
                        copy($dir2copy . $mediaDir . '/' . $fichier . "." . $newItemExtention, $dir_paste . $fileCopy . "." . $newItemExtention);

                        // Mise à jour de Questionnaire suivant le type de média
                        switch ($fichier) {
                            case 'consigne':
                                $questionnaire->setMediaInstruction($media);
                                break;
                            case 'texte':
                                $questionnaire->setMediaText($media);
                                break;
                            case 'contexte':
                                $questionnaire->setMediaContext($media);
                                break;
                        }

                        // Enregistrement en base
                        $em->persist($questionnaire);
                        $em->flush();
                    }
                }
              // On ferme $dir2copy
              closedir($dh);
            }
       }
    }

    /**
     * processAmorceSubquestion function
     *
     */
    private function processAmorceSubquestion($i, Subquestion $subQuestion, $dir2copy, $dir_paste, $data)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaDir = $data[1];
        $typo = $data[4];

        if ($typo[0] == "T" && $typo != "TVF" && $typo != "TVFPM") {
            $testFile = $dir2copy . $mediaDir . "/amorce_" . $i. ".mp3";
        } else {
            $testFile = $dir2copy . $mediaDir . "/amorce.mp3";
        }

        if (file_exists($testFile)) {
            $media = new Media();
            $media->setUrl($mediaDir . "_amorce_" . $i . "_" . uniqid());
            $media->setName($mediaDir . "_amorce_" .$i);
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));
            $em->persist($media);
            $subQuestion->setMediaAmorce($media);

            copy($testFile, $dir_paste . $media->getUrl() . ".mp3");
        }
    }

    /**
     * tqrProcess function
     *
     */
    private function tqrProcess(Typology $typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Traitement sur le nombre d'items
        for ($i = 1; $i <= $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
            $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
            $subQuestion->setTypology($typoSubQuestion);
            $subQuestion->setQuestion($question);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
        //    $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 10+(2*$i);
            // Changement d'ordre par rapport au pilote de décembre Anglais et avant Italien.
            $nbProposition = $data[$indice];
            $rightAnswer = $data[$indice+1];

            for ($j=1; $j <= $nbProposition; $j++) {
                $this->propositionProcess($i, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
            }
        }
    }

    /**
     * qrProcess function
     *
     */
    private function qrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        // Traitement sur le nombre d'items
        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);

        // Créer une occurrence dans la table "Proposition"
        // Changement d'ordre par rapport au pilote de décembre Anglais et avant Italien.
        $nbProposition = $data[12];
        $rightAnswer = $data[13];

        $tab = explode("#", $data[12]);
        $type = $tab[0];
        if ($type == "QRU") {
            $countTab = count($tab);
            for ($compteurTab = 1; $compteurTab < $countTab; $compteurTab++)
            {
                $this->vfPropositionProcess($rightAnswer, $tab[$compteurTab], $compteurTab, $subQuestion);
            }
        }
        else
        {
            for ($j=1; $j <= $nbProposition; $j++) {
                $this->propositionProcess(1, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
            }
        }

    }

    /**
     * vfProcess function
     *
     */
    private function vfProcess(Typology $typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();


        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        $dirName = $data[1];

        // Traitement sur le nombre d'items
        for ($i = 1; $i <= $nbItems; $i++) {
            $subQuestion = new Subquestion();
            if ($i == 1) $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $ctrlTypo = $typo->getName();
            if ($ctrlTypo[0] == "T") {
                $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
                $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
                $subQuestion->setTypology($typoSubQuestion);
            } else {
                $subQuestion->setTypology($typo);
            }
            $subQuestion->setQuestion($question);

            // Recherche si le fichier existe
            // S'il n'existe pas, je passe au suivant.
            //
            $fileName = "option_" . $i;
            $testFile = $dir2copy . $dirName . '/' . $fileName . ".mp3";

            if (file_exists($testFile)) {
                // Création dans "Media"
                $media = new Media();
                $media->setName($dirName . "_" . $fileName);
                $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

                $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                $media->setMediaType($mediaType);
                $subQuestion->setMedia($media);

                // Enregistrement en base
                $em->persist($media);
                copy($dir2copy . $dirName . "/" . $fileName . ".mp3", $dir_paste . '/' . $media->getUrl() . ".mp3");
            }

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            //$rightAnswer = $data[$indice-1];
            $rightAnswer = $data[$indice]; // Changement 14/02/2014 car décalage du fichier.

            $Vrai = "VRAI";

            $tab = explode("#", $data[12]);
            //var_dump($tab);
            $type = $tab[0];
            if ($data[12] != "VF") {
                $vrai = $tab[1];
                $this->vfPropositionProcess($rightAnswer, $vrai, "V", $subQuestion);
                $faux = $tab[2];
                $this->vfPropositionProcess($rightAnswer, $faux, "F", $subQuestion);
            }
            else
            {
                $this->vfPropositionProcess($rightAnswer, "VRAI", "V", $subQuestion);
                $this->vfPropositionProcess($rightAnswer, "FAUX", "F", $subQuestion);
            }

            if ($data[$indice] == "VFPM") {
                $this->vfPropositionProcess($rightAnswer, "PM", "PM", $subQuestion); // PM : à confirmer
            }
        }
    }

    /**
     * tvfnmProcess function
     *
     */
    private function tvfnmProcess(Typology $typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();


        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        $dirName = $data[1];

        // Traitement sur le nombre d'items
        for ($i = 1; $i <= $nbItems; $i++) {
            $subQuestion = new Subquestion();
            if ($i == 1) $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $ctrlTypo = $typo->getName();
            if ($ctrlTypo[0] == "T") {
                $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
                $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
                $subQuestion->setTypology($typoSubQuestion);
            } else {
                $subQuestion->setTypology($typo);
            }
            $subQuestion->setQuestion($question);

            // Recherche si le fichier existe
            // S'il n'existe pas, je passe au suivant.
            //
            $fileName = "option_" . $i;
            $testFile = $dir2copy . $dirName . '/' . $fileName . ".mp3";

            if (file_exists($testFile)) {
                // Création dans "Media"
                $media = new Media();
                $media->setName($dirName . "_" . $fileName);
                $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

                $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                $media->setMediaType($mediaType);
                $subQuestion->setMedia($media);

                // Enregistrement en base
                $em->persist($media);
                copy($dir2copy . $dirName . "/" . $fileName . ".mp3", $dir_paste . '/' . $media->getUrl() . ".mp3");
            }

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            // Créer une occurrence dans la table "Proposition"
            $indice = 10+(2*$i);
            //$rightAnswer = $data[$indice-1];
            $rightAnswer = $data[$indice+1]; // Changement 14/02/2014 car décalage du fichier.

                $this->vfPropositionProcess($rightAnswer, "VRAI", "V", $subQuestion);
                $this->vfPropositionProcess($rightAnswer, "FAUX", "F", $subQuestion);
                $this->vfPropositionProcess($rightAnswer, "ND", "ND", $subQuestion); // PM : à confirmer
        }
    }






















    /**
     * vfPropositionProcess function
     *
     */
    private function vfPropositionProcess($rightAnswer, $nameProposition, $expectedAnswer, $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);
        if ($rightAnswer == $expectedAnswer) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        if (!$media = $em->getRepository('InnovaSelfBundle:Media')->findOneByName($nameProposition)) {
            // Création dans "Media"
            $media = new Media();
            $media->setDescription($nameProposition); // Ajout contrôle existance V ou F
            $media->setName($nameProposition); // Ajout contrôle existance V ou F

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte");
            $media->setMediaType($mediaType);
        }
        $em->persist($media);

        $proposition->setMedia($media);
        $em->persist($proposition);

        $em->flush();
    }

    /**
     * appatProcess function
     *
     */
    private function appatProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        $medias = array();
/*
        $nbItems = $data[11];
        for ($i=0; $i < $nbItems; $i++) {
            $indice = 12+(2*$i);
            $this->mediaAppatProcess($data[$indice], $medias);
        }

*/
        $tab = explode("#", $data[12]);
        $countTab = count($tab);
        for ($j = 1; $j < $countTab; $j++)
        {
            $this->mediaAppatProcess($tab[$j], $medias);
        }

        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);
            $this->processMediaSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
        //    $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
/*
            $nbMedias = count($medias); #80
            for ($j=0; $j < $nbMedias; $j++) {
                $this->propositionAppatProcess($i, $j, $subQuestion, $medias[$j]);
            }
*/
//            $tab = explode("#", $data[12]);
//            $countTab = count($tab);
            $nbMedias = count($medias); #80
            for ($j=0; $j < $nbMedias; $j++)
            {
                $this->propositionAppatProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * processMediaSubquestion function
     *
     */
    private function processMediaSubquestion($i, $subQuestion,  $dir2copy, $dir_paste, $data)
    {

        $em = $this->getDoctrine()->getManager();

        $dirName = trim($data[1]);
        $fileName = "option_" . $i;
        $testFile = $dir2copy . $dirName . '/' . $fileName . ".mp3";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
            $media->setMediaType($mediaType);
            $subQuestion->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            copy($dir2copy . $dirName . "/" . $fileName . ".mp3", $dir_paste . $media->getUrl() . ".mp3");
        }

        // Enregistrement en base
        $em->persist($subQuestion);
        //$em->flush();
    }


    /**
     * propositionAppatProcess function
     *
     */
    private function propositionAppatProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * qruiProcess function
     *
     */
    private function qruiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);
        // $em->flush();

        // Créer une occurrence dans la table "Proposition"
        $nbProposition = $data[13];
        $rightAnswer = $data[12];

        for ($j=1; $j <= $nbProposition; $j++) {
            $this->propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $data[1], $dir_paste);
        }
    }

    /**
     * propositionQruiProcess function
     *
     */
    private function propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $dirName, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($j == $rightAnswer) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        // Recherche si le fichier existe
        // S'il n'existe pas, je passe au suivant.
        //
        $fileName = "option_" . $j;
        $testFile = $dir2copy . $dirName . '/' . $fileName . ".jpg";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid() . ".jpg");

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            copy($dir2copy . $dirName . "/" . $fileName . ".jpg", $dir_paste . $fileName . ".jpg");
        }

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * propositionProcess function
     *
     */
    private function propositionProcess($i, $j, $rightAnswer, $dirName, $subQuestion, $dir2copy, $dir_paste, $nbItems)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        // Formatage et test si le fichier existe
        // exemple de nom de fichier : option_1_2.mp3
        if ($nbItems == 1 ) // Test QRU/QRM
            $fileName = "option" . "_" . $j;
        else
            $fileName = "option" . "_" . $i . "_" . $j;

        $pathFileName = $dir2copy . $dirName . "/" . $fileName;

        $extension = ".mp3";

        if (file_exists($pathFileName . $extension)) {
            if (preg_match("/".$j."/", $rightAnswer)) {
                $proposition->setRightAnswer(true);
            } else {
                $proposition->setRightAnswer(false);
            }

            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            copy($pathFileName . $extension, $dir_paste . '/' . $media->getUrl() . $extension);
        } else {
        }

        $extension = ".jpg";

        if (file_exists($pathFileName . $extension)) {
            if (preg_match("/".$j."/", $rightAnswer)) {
                $proposition->setRightAnswer(true);
            } else {
                $proposition->setRightAnswer(false);
            }

            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            copy($pathFileName . $extension, $dir_paste . '/' . $media->getUrl() . $extension);
        } else {
        }


        $extension = ".flv";

        if (file_exists($pathFileName . $extension)) {
            if (preg_match("/".$j."/", $rightAnswer)) {
                $proposition->setRightAnswer(true);
            } else {
                $proposition->setRightAnswer(false);
            }

            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("video");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            copy($pathFileName . $extension, $dir_paste . '/' . $media->getUrl() . $extension);
        } else {
        }

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();

    }

    /**
     * mediaAppatProcess function
     *
     */
    private function mediaAppatProcess($texte, &$medias)
    {

        $em = $this->getDoctrine()->getManager();
        // Création dans "Media"
        $media = new Media();
        $media->setName($texte);
        $media->setDescription($texte);

        $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte");
        $media->setMediaType($mediaType);

        $em->persist($media);
        $medias[] = $media;
    }

     /**
     * dragAction function
     *
     * @Route(
     *     "/drag",
     *     name = "drag",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function dragAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InnovaSelfBundle:Typology')->findAll();

        return array(
            'entities' => $entities
        );
    }

    /**
     * dragNew function
     *
     * @Route(
     *     "/drag/new",
     *     name = "drag_new",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function dragNewAction()
    {

        //#78
        // Ici, on peut faire le traitement suite à la validation.
        //
        // Appel de la redirection après la validation.
        return $this->redirect($this->generateUrl('drag'));

    }

}
