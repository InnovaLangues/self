<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Form\TestType;
use Innova\SelfBundle\Entity\MediaType;
use Symfony\Component\Security\Core\Util\SecureRandom;

use Symfony\Component\HttpFoundation\Session\Session;

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

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->findOneNotDoneYetByUserByTest($test->getId(), $user->getId());

        $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->CountDoneYetByUserByTest($test->getId(), $user->getId());

        $countQuestionnaire = count($test->getQuestionnaires());

        // Session to F5 key and sesion.
        $session->set('listening', $questionnaire->getListeningLimit());

        if (is_null($questionnaire)) {

            return $this->redirect(
                $this->generateUrl(
                    'test_end',
                    array("id"=>$test->getId())
                )
            );
        }

        // One color per language. Two languages for the moment : ang and it.
        // In database, we must have "ang" in english test and "it" in italian test.
        // See main.css for more information.
        $language = "default";
        if (preg_match("/ang/i", $test->getName() )) $language = "eng";
        if (preg_match("/it/i", $test->getName() )) $language = "it";

        // $questionnaire = $this->getRandom($questionnaires);
        return array(
            'questionnaire' => $questionnaire,
            'language' => $language,
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
        $nbAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->CountAnswerByUserByTest($test->getId(), $user->getId());

        $nbRightAnswer = $em->getRepository('InnovaSelfBundle:Questionnaire')
                            ->CountRightAnswerByUserByTest($test->getId(), $user->getId());

        return array("nbRightAnswer" => $nbRightAnswer, "nbAnswer" => $nbAnswer);
    }


    /*
    private function getRandom($questionnaires)
    {
        $nb_questionnaire = count($questionnaires) -1;
        $rnd = rand(0,$nb_questionnaire);

        return $questionnaires[$rnd];
    }
    */

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
     * @Method("GET")
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
     *     "/csv",
     *     name = "csv-export",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
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

        // First line
        //$csv .= "NOM" . ";" ; // A
        //$csv .= "DATE" . ";" ; // B
        //$csv .= "TEMPS (s)" . ";" ; // C
        // CR
        //$csv .= "\n";

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
                    /*if (in_array($userName, $result)) {
                        echo "trouvé" . "<br />";
                        $result[$userName]["time"] = $result[$userName]["time"] + $trace->getTotalTime();
                    } else {
                        $result[$userName]["time"] = 0;
                        echo "pas trouvé " . $userName . "<br />";
                    }*/
                    $result[$userName]["name"]  = $userName;
                    $result[$userName]["email"] = $emailName;
                    $result[$userName]["date"]  = $testDate;
                }
            }
        }

        foreach ($result as $key => $value) {
            //foreach ($result[$key] as $key2 => $value2) {
                //echo $key . "/" . $result[$key]["name"] . "/" . $result[$key]["time"]. "<br />";
                //$csv .= $result[$key]["name"] . ";" . $result[$key]["date"] . ";" . $result[$key]["time"] . ";" ;
                // CR
                //$csv .= "\n";
            //}
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
            if ($cpt_questionnaire == 0)
            {
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
                    if (!is_numeric($themeCode))
                    {
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
                            //$csv .= "T" . $cpt_questionnaire . "-CORR-FAUX " . $cpt . ";" ; // Ajout d'une colonne pour chaque proposition de la question.
                            $csv .= "t" . $themeCode . "res" . $cpt . ";"; // Ajout d'une colonne pour chaque proposition de la question.
                            /*foreach ($propositions as $proposition) {
                                    //echo $proposition->getRightAnswer();
                            }*/
                            //$csv .= "T" . $cpt_questionnaire . "-prop. choisie;" ;
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
            //$questionnaires = $test->getQuestionnaires();
            //$questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAllByTest($test);
            foreach ($users as $user) {
                $csv .= $user->getEmail() . ";" ;
                $csv .= $user->getUserName() . ";" ;
                $csv .= $user->getFirstName() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
                //
                $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                    ->CountDoneYetByUserByTest($test->getId(), $user->getId());

                $countQuestionnaire = count($test->getQuestionnaires());

                if ($countQuestionnaireDone > 0)
                {
                    $csv .= $result[$user->getUserName()]["date"] . ";" . $result[$user->getUserName()]["time"] . ";";
                    // Add 5 colums for Level
                    //
                    $csv .= $user->getStudentType() . ";";
                    $csv .= $user->getLastLevel() . ";";
                    $csv .= $user->getCoLevel() . ";";
                    $csv .= $user->getCeLevel() . ";";
                    $csv .= $user->getEeLevel() . ";";
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
                            //echo "trace = " . $trace->getId() . "-" . $user->getId() . "-" . $trace->getTotalTime() . "<br />";

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
                                    //$csv .= "proposition " . $propositionRank . ";";
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
     *     "/csv-import",
     *     name = "csv-import",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function importCsvSQLAction()
    {
        $em = $this->getDoctrine()->getManager();

        //
        // CSV Import part
        //

        // File import path
        $csvPathImport    =__DIR__.'/../../../../web/upload/import/csv/'; // Symfony
        $csvPathImportMp3 =__DIR__.'/../../../../web/upload/import/mp3/'; // Symfony

        // File import name
        $csvName = 'test-import.csv';
        $csvName = 'mp2-ok.csv'; // Suite réception MP.

        // Symfony
        $urlCSVRelativeToWeb = 'upload/import/csv/';
        // Path + Name
        $csvPath = $csvPathImport . $csvName;

        // File import path
        // Répertoire où seront stockés les fichiers
        $dir2copy =__DIR__.'/../../../../web/upload/import/mp3/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        $dir_paste =__DIR__.'/../../../../web/upload/media/'; // A modifier quand on aura l'adresse

        // Traitement des fichiers reçus
        if ($dossier = opendir($csvPathImportMp3)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $exp = explode("_", $fichier);

                    $repertoryName = strtolower($exp[0]);
                    $fileName = $exp[1];

                    $repertoryMkDir = $csvPathImportMp3 . $repertoryName;
                    // Création du répertoire (s'il n'est pas déjà créé)
                    if(!is_dir($repertoryMkDir)) mkdir ($repertoryMkDir, 0777);

                    if (preg_match("/amorce/i", $fileName))
                    {
                        copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/amorce.mp3");
                    }
                    if (preg_match("/option/i", $fileName))
                    {
                        $number = explode(".", $exp[2]);
                        copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/option_" . $number[0] . ".mp3");
                    }
                    if (preg_match("/txt/i", $fileName))
                    {
                        copy($csvPathImportMp3 . $fichier, $repertoryMkDir . "/texte.mp3");
                    }
                }
            }
        }

        // Traitement du fichier d'entrée afin de ne pas prendre la ou les premières lignes.
        // Contrainte :
        // dans la colonne "A", il faut une donnée de type "entier" séquentielle (1 puis 2 ...)
        // Cette contrainte a été prise en compte par rapport au fichier reçu.
        $row = 0;
        $indice = 0;

        //echo $csvPath;
        if (($handle = fopen($csvPath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                // Nombre de colonnes
                $num = count($data);
                $c = 0;
                // Ainsi, je ne prends pas les intitulés des colonnes
                if ($row != 0)
                {
                    //
                    //
                    // Première partie : ajout dans la table Questionnaire
                    //
                    //

                    // Add to Questionnaire table
                    $questionnaire = new Questionnaire();
                    $testName = "CO-pilote-dec2013-ang";
                    if(!$test =  $em->getRepository('InnovaSelfBundle:Test')->findOneByName($testName)){
                        $test = new Test();
                        $test->setName($testName);
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

                    // Enregistrement en base
                    $em->persist($questionnaire);
                    //$em->flush();

                    //
                    //
                    // Deuxième partie : traitement des fichiers de type "Media"
                    //
                    //
                    // $data[1]  = nom du répertoire = nom du thême
                    // $data[10] = nom de l'extension du fichier (ex : mp3)
                    // $idQuestionnaire = id du questionnaire créé
                    $this->copieFileDir($data[1], $data[10], $questionnaire, $dir2copy, $dir_paste);

                    //
                    //
                    // Troisième partie : travail sur les types TQRM et TQRU
                    //
                    //

                    // Traitement suivi le type de questionnaire.
                    switch($data[4])
                    {
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
    public function appaiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
        for ( $i = 0; $i < $nbItems; $i++ )
        {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaiSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            for ($j = 0; $j < count($medias); $j++) {
                $this->propositionAppaiProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaiPropositionProcess function
     *
     */
    public function mediaAppaiPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
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
    public function mediaAppaiSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, $subQuestion)
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
    public function propositionAppaiProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function appaaProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
        for ( $i = 0; $i < $nbItems; $i++ )
        {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaaSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            for ($j = 0; $j < count($medias); $j++) {
                $this->propositionAppaaProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaaSubQuestionProcess function
     *
     */
    public function mediaAppaaSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, $subQuestion)
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
    public function mediaAppaaPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
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
    public function propositionAppaaProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function copieFileDir($mediaDir, $itemExtention, $questionnaire, $dir2copy, $dir_paste)
    {

        $em = $this->getDoctrine()->getManager();

        // File import path
        // Répertoire où seront stockés les fichiers
        //$dir2copy =__DIR__.'/../../../../web/upload/test_eric/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        //$dir_paste =__DIR__.'/../../../../web/upload/test_eric/media/'; // A modifier quand on aura l'adresse

        if (is_dir($dir2copy))
        {
            // Si oui, on l'ouvre
            if ($dh = opendir($dir2copy))
            {
                $filesToCopy = array('consigne', 'texte', 'contexte');
                // Consigne = audio
                // Item = cf Excel
                // Contexte = audio
                foreach ($filesToCopy as $fichier)
                {

                    if ($fichier != 'texte') {
                        $newItemExtention = "mp3";
                    }
                    else{
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
                        if ($fichier != 'texte')
                        {
                            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                        }
                        else
                        {
                            foreach ($aMedia["extension"] as $key => $value) {
                                if(in_array($newItemExtention, $value)){
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
    public function processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaDir = $data[1];
        $typo = $data[4];

        if ($typo[0] == "T" && $typo != "TVF" && $typo != "TVFPM")
        {
            $testFile = $dir2copy . $mediaDir . "/amorce_" . $i. ".mp3";
        }
        else{
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
    public function tqrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Traitement sur le nombre d'items
        for ( $i = 1; $i <= $nbItems; $i++ )
        {
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
            $indice = 11+(2*$i);
            $nbProposition = $data[$indice];
            $rightAnswer = $data[$indice-1];

            for ($j=1; $j <= $nbProposition; $j++) {
                $this->propositionProcess($i, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
            }
        }
    }

    /**
     * qrProcess function
     *
     */
    public function qrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        // Traitement sur le nombre d'items
        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);
        //$em->flush();

        // Créer une occurrence dans la table "Proposition"
        $nbProposition = $data[13];
        $rightAnswer = $data[12];

        //echo $rightAnswer . " - " . $nbProposition;
        for ($j=1; $j <= $nbProposition; $j++) {
            $this->propositionProcess(1, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
        }
    }

    /**
     * vfProcess function
     *
     */
    public function vfProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
        for ( $i = 1; $i <= $nbItems; $i++ )
        {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            if ($i == 1) $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $ctrlTypo = $typo->getName();
            if ($ctrlTypo[0] == "T")
            {
                $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
                $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
                $subQuestion->setTypology($typoSubQuestion);
            }
            else
            {
                $subQuestion->setTypology($typo);
            }
            $subQuestion->setQuestion($question);

            // Recherche si le fichier existe
            // S'il n'existe pas, je passe au suivant.
            //
            $fileName = "option_" . $i;
            $testFile = $dir2copy . $dirName . '/' . $fileName . ".mp3";
            //echo "<br />Test Copie : " . $testFile;

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
                //echo "<br />Copie : " . $dir2copy . $dirName . "/" . $fileName . ".mp3" . " TO " . $dir_paste . '/' . $media->getUrl() . ".mp3";
                copy($dir2copy . $dirName . "/" . $fileName . ".mp3", $dir_paste . '/' . $media->getUrl() . ".mp3");
            }

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
            // $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            $rightAnswer = $data[$indice-1];

            $this->vfPropositionProcess($rightAnswer, "VRAI", "V", $subQuestion);
            $this->vfPropositionProcess($rightAnswer, "FAUX", "F", $subQuestion);

            if ($data[$indice] == "VFPM")
            {
                $this->vfPropositionProcess($rightAnswer, "PM", "PM", $subQuestion); // PM : à confirmer
            }
        }
    }

    /**
     * vfPropositionProcess function
     *
     */
    public function vfPropositionProcess($rightAnswer, $nameProposition, $expectedAnswer, $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);
        if ($rightAnswer == $expectedAnswer)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
            $proposition->setRightAnswer(false);
        }

        if (!$media = $em->getRepository('InnovaSelfBundle:Media')->findOneByName($nameProposition)){
            // Création dans "Media"
            $media = new Media();
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
    public function appatProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        $medias = array();
        $nbItems = $data[11];
        for ($i=0; $i < $nbItems; $i++) {
            $indice = 12+(2*$i);
            $this->mediaAppatProcess($data[$indice], $medias);
        }

        // Traitement sur le nombre d'items
        for ( $i = 0; $i < $nbItems; $i++ )
        {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
        //    $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            $nbProposition = $data[$indice];
            $rightAnswer = $data[$indice-1];

            for ($j=0; $j < count($medias); $j++) {
                $this->propositionAppatProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * propositionAppatProcess function
     *
     */
    public function propositionAppatProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function qruiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
    public function propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $dirName, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($j == $rightAnswer)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function propositionProcess($i, $j, $rightAnswer, $dirName, $subQuestion, $dir2copy, $dir_paste, $nbItems)
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

        //echo "<br />path : " . $pathFileName . $extension;

        if (file_exists($pathFileName . $extension)) {
            //echo " TROUVE !";
            if (preg_match("/".$j."/", $rightAnswer))
            {
                $proposition->setRightAnswer(true);
            }
            else
            {
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
        }
        else
        {
            //echo " PAS TROUVE !";
        }

        //var_dump($proposition);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();

    }

    /**
     * mediaAppatProcess function
     *
     */
    public function mediaAppatProcess($texte, &$medias)
    {
        $em = $this->getDoctrine()->getManager();
        // Création dans "Media"
        $media = new Media();
        $media->setName($texte);

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

        echo "ici";
        die();
        // Ici, on peut faire le traitement suite à la validation.
        //
        // Appel de la redirection après la validation.
        return $this->redirect($this->generateUrl('drag'));

    }

}
