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
use Innova\SelfBundle\Form\TestType;

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
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->findOneNotDoneYetByUserByTest($test->getId(), $user->getId());

        $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->CountDoneYetByUserByTest($test->getId(), $user->getId());

        $countQuestionnaire = count($test->getQuestionnaires());

        if (is_null($questionnaire)) {

            return $this->redirect(
                $this->generateUrl(
                    'test_end',
                    array("id"=>$test->getId())
                )
            );
        }



        // $questionnaire = $this->getRandom($questionnaires);
        return array(
            'questionnaire' => $questionnaire,
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
        $csv .= "NOM" . ";" ; // A
        $csv .= "DATE" . ";" ; // B
        $csv .= "TEMPS (s)" . ";" ; // C
        // CR
        $csv .= "\n";

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
                $csv .= $result[$key]["name"] . ";" . $result[$key]["date"] . ";" . $result[$key]["time"] . ";" ;
                // CR
                $csv .= "\n";
            //}
        }

        $csv .= "\n";
        $csv .= "\n";

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

/*
        $csv .= "DIFFICULTE" . ";" ; // B
        $csv .= "TEMPS (s)" . ";"  ; // C
        $csv .= "REPONSES" . ";" ; // D
        // CR
        $csv .= "\n";
        $csv .= "\n";
*/

        // HEADER
        // Loop to display all questionnaire of the test
        $csv .= "Code étudiant;" ; // A
        foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            $cpt_questionnaire=0;
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                $cpt_questionnaire++;
                $csv .= "T" . $cpt_questionnaire . "-" . $questionnaire->getTheme() . ";";
                $csv .= "T" . $cpt_questionnaire . "-Diff.;";
                $csv .= "T" . $cpt_questionnaire . "-TEMPS;";
                $questions = $questionnaire->getQuestions();
                foreach ($questions as $question) {
                    $subquestions = $question->getSubQuestions();
                    $cpt=0;
                    foreach ($subquestions as $subquestion) {
                        $cpt++;
                        $csv .= "T" . $cpt_questionnaire . "-CORR-FAUX " . $cpt . ";" ; // Ajout d'une colonne pour chaque proposition de la question.
                        /*foreach ($propositions as $proposition) {
                                //echo $proposition->getRightAnswer();
                        }*/
                        $csv .= "T" . $cpt_questionnaire . "-prop. choisie;" ;
                    }
                }
            }
        }

        $csv .= "\n";

        // BODY
        // Loop to display all data
        foreach ($tests as $test) {
            $users = $test->getUsers();
            //$questionnaires = $test->getQuestionnaires();
            //$questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAllByTest($test);
            foreach ($users as $user) {
                $csv .= $user->getUserName() . " " . $user->getEmail() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
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
                                $csv .= "proposition " . $propositionRank . ";";
                            }
                        }
                    }
                }
                $csv .= "\n";
            }
        }

        // Loop to display all data
        /*foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                // For THE questionnaire, loop on the Trace
                $traces = $questionnaire->getTraces();
                foreach ($traces as $trace) {
                    $answers = $trace->getAnswers();

                    $csv .= $trace->getUser() . " " . $trace->getUser()->getEmail() . ";" ;
                    $csv .= ";" ; // A
                    $csv .= $trace->getDifficulty(). ";" ;
                    $csv .= $trace->getTotalTime().";" ;


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
                            $csv .= "proposition " . $propositionRank . ";";
                        }
                    }
                    // CR
                    $csv .= "\n";
                }
            }
            // CR
            $csv .= "\n";
        }*/


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
        $csvPathImport =__DIR__.'/../../../../web/upload/import/csv/'; // Symfony

        // File import name
        $csvName = 'codage-protocoles.csv';

        // Symfony
        $urlCSVRelativeToWeb = 'upload/import/csv/';

        // Path + Name
        $csvPath = $csvPathImport . $csvName;

        // Traitement du fichier d'entrée afin de ne pas prendre la ou les premières lignes.
        // Contrainte :
        // dans la colonne "A", il faut une donnée de type "entier" séquentielle (1 puis 2 ...)
        // Cette contrainte a été prise en compte par rapport au fichier reçu.
        $row = 0;
        $indice = 0;
        if (($handle = fopen($csvPath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Nombre de colonnes
                $num = count($data);
                $c = 0;
                // Ainsi, je ne prends pas les intitulés des colonnes
                if ($data[$c] = $row)
                {
                    // Add to Questionnaire table
                    $entity = new Questionnaire();

                    //
                    // J'ai traité les colonnes de la table Questionnaire dans l'ordre
                    //

                    // Traitement sur le level
                    $libLevel = $data[2];
                    $level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($libLevel);
                    $entity->setLevel($level);

                    // Traitement sur le skill
                    $libSkill = $data[3];
                    $skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($libSkill);
                    $entity->setSkill($skill);

                    // Traitement des autres colonnes
                    $entity->setAuthor();
                    $entity->setInstruction();
                    $entity->setSource();
                    $entity->setDuration();
                    $entity->setDomain();
                    $entity->setSupport();
                    $entity->setFlow();
                    $entity->setFocus();
                    $entity->setTheme("");

                    //Dialogue
                    $entity->setDialogue(0);
                    // Vu avec Arnaud : 1 pour Dialogue / 0 pour Monologue
                    $libDialogue = $data[8];
                    $pos = strripos($libDialogue, 'dialogue');

                    if ($pos === false) {
                        $pos = strripos($libDialogue, 'monologue');
                        if (!($pos === false)) {
                            $entity->setDialogue(0);
                        }
                    } else {
                        $entity->setDialogue(1);
                    }

                    //ListeningLimit
                    $entity->setListeningLimit($data[9]);

                    //Autres colonnes
                    $entity->setAudioInstruction("");
                    $entity->setAudioContext("");
                    $entity->setAudioItem("");
                    $entity->setSource();
                    $entity->setReceptionType();
                    $entity->setFunctionType();
                    $entity->setCognitiveOperation();
                    $entity->setLanguageLevel();
                    $entity->setOriginText("");
                    $entity->setExerciceText("");

                    // Enregistrement en base
                    $em->persist($entity);
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
     * importCsvSQL function
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
