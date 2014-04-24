<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Questionnaire;

/**
 * Questionnaire controller.
 *
 * @Route("/editor")
 */
class QuestionnaireController extends Controller
{

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/questionnaires", name="editor_questionnaire_list")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:list.html.twig")
     */
    public function listQuestionnairesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();

        return array(
            'questionnaires' => $questionnaires
        );
    }

    /**
     * Finds and displays a Questionnaire entity.
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:show.html.twig")
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        return array(
            'questionnaire' => $questionnaire
        );
    }

    /**
     * Creates a new Questionnaire entity.
     *
     * @Route("/questionnaires", name="editor_questionnaire_create")
     * @Method("POST")
     * @Template("")
     */
    public function createAction(Request $request)
    {
        $questionnaire = new Questionnaire();

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été créé.'
                );

        return $this->  redirect($this->generateUrl(
                            'editor_questionnaire_show',
                            array('id' => $entity->getId()))
                        );
    }

    /**
     * Updates a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_edit")
     * @Method("PUT")
     * @Template("")
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été créé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

     /**
     * Delete a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_delete")
     * @Method("DELETE")
     * @Template("")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été supprimé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

}
