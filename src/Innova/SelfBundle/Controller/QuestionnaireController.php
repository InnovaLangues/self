<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Form\QuestionnaireType;

/**
 * Questionnaire controller.
 *
 * @Route("admin/questionnaire")
 */
class QuestionnaireController extends Controller
{

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/", name="questionnaire")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Questionnaire entity.
     *
     * @Route("/", name="questionnaire_create")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Questionnaire:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Questionnaire();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('questionnaire_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Questionnaire entity.
    *
    * @param Questionnaire $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Questionnaire $entity)
    {
        $form = $this->createForm(new QuestionnaireType(), $entity, array(
            'action' => $this->generateUrl('questionnaire_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Questionnaire entity.
     *
     * @Route("/new", name="questionnaire_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Questionnaire();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Questionnaire entity.
     *
     * @Route("/{id}", name="questionnaire_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Questionnaire entity.
     *
     * @Route("/{id}/edit", name="questionnaire_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
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
    * Creates a form to edit a Questionnaire entity.
    *
    * @param Questionnaire $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Questionnaire $entity)
    {
        $form = $this->createForm(new QuestionnaireType(), $entity, array(
            'action' => $this->generateUrl('questionnaire_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Questionnaire entity.
     *
     * @Route("/{id}", name="questionnaire_update")
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Questionnaire:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('questionnaire_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Questionnaire entity.
     *
     * @Route("/{id}", name="questionnaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Questionnaire entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('questionnaire'));
    }

    /**
     * Creates a form to delete a Questionnaire entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('questionnaire_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
