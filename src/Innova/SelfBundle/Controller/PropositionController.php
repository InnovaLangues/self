<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Form\PropositionType;

/**
 * Proposition controller.
 *
 * @Route("/proposition")
 */
class PropositionController extends Controller
{

    /**
     * Lists all Proposition entities.
     *
     * @Route("/", name="proposition")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InnovaSelfBundle:Proposition')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Proposition entity.
     *
     * @Route("/", name="proposition_create")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Proposition:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Proposition();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('proposition_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Proposition entity.
    *
    * @param Proposition $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Proposition $entity)
    {
        $form = $this->createForm(new PropositionType(), $entity, array(
            'action' => $this->generateUrl('proposition_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Proposition entity.
     *
     * @Route("/new", name="proposition_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Proposition();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Proposition entity.
     *
     * @Route("/{id}", name="proposition_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Proposition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proposition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Proposition entity.
     *
     * @Route("/{id}/edit", name="proposition_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Proposition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proposition entity.');
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
    * Creates a form to edit a Proposition entity.
    *
    * @param Proposition $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Proposition $entity)
    {
        $form = $this->createForm(new PropositionType(), $entity, array(
            'action' => $this->generateUrl('proposition_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Proposition entity.
     *
     * @Route("/{id}", name="proposition_update")
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Proposition:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InnovaSelfBundle:Proposition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proposition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('proposition_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Proposition entity.
     *
     * @Route("/{id}", name="proposition_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InnovaSelfBundle:Proposition')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proposition entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proposition'));
    }

    /**
     * Creates a form to delete a Proposition entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proposition_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
