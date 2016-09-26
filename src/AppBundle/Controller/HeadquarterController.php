<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Headquarter;
use AppBundle\Form\HeadquarterType;

/**
 * Headquarter controller.
 *
 * @Route("/headquarter")
 */
class HeadquarterController extends Controller
{
    /**
     * Lists all Headquarter entities.
     *
     * @Route("/", name="headquarter_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $headquarters = $em->getRepository('AppBundle:Headquarter')->findAll();

        return $this->render('headquarter/index.html.twig', array(
            'headquarters' => $headquarters,
        ));
    }

    /**
     * Creates a new Headquarter entity.
     *
     * @Route("/new", name="headquarter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $headquarter = new Headquarter();
        $form = $this->createForm('AppBundle\Form\HeadquarterType', $headquarter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($headquarter);
            $em->flush();

            return $this->redirectToRoute('headquarter_show', array('id' => $headquarter->getId()));
        }

        return $this->render('headquarter/new.html.twig', array(
            'headquarter' => $headquarter,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Headquarter entity.
     *
     * @Route("/{id}", name="headquarter_show")
     * @Method("GET")
     */
    public function showAction(Headquarter $headquarter)
    {
        $deleteForm = $this->createDeleteForm($headquarter);

        return $this->render('headquarter/show.html.twig', array(
            'headquarter' => $headquarter,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Headquarter entity.
     *
     * @Route("/{id}/edit", name="headquarter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Headquarter $headquarter)
    {
        $deleteForm = $this->createDeleteForm($headquarter);
        $editForm = $this->createForm('AppBundle\Form\HeadquarterType', $headquarter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($headquarter);
            $em->flush();

            return $this->redirectToRoute('headquarter_edit', array('id' => $headquarter->getId()));
        }

        return $this->render('headquarter/edit.html.twig', array(
            'headquarter' => $headquarter,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Headquarter entity.
     *
     * @Route("/{id}", name="headquarter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Headquarter $headquarter)
    {
        $form = $this->createDeleteForm($headquarter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($headquarter);
            $em->flush();
        }

        return $this->redirectToRoute('headquarter_index');
    }

    /**
     * Creates a form to delete a Headquarter entity.
     *
     * @param Headquarter $headquarter The Headquarter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Headquarter $headquarter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('headquarter_delete', array('id' => $headquarter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
