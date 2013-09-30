<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
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

        // File export name
        $csvName = 'export-' . date("Ymd_d-m-Y_H:i:s") . '.csv';

        // File export path
        $csvPathExport =__DIR__.'/../../../../web/upload/export/csv/'; // Symfony

        $urlCSVRelativeToWeb = 'upload/export/csv/'; // Symfony

        // Path + Name
        $csvPath = $csvPathExport . $csvName;

        // Open file
        $csvh = fopen($csvPath, 'w+');

        // Init csv write variable
        $csv = '';

        // Loop for test
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                $csv .= $questionnaire->getTheme() . ";\n";

                // For THE questionnaire, loop on the Trace
                $traces = $questionnaire->getTraces();
                foreach ($traces as $trace) {
                    $answers = $trace->getAnswers();

                    $csv .= $trace->getUser() . ";" ;

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
                // CR
                $csv .= "\n";
            }
        }

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
}
