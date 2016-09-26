<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Survey;
use AppBundle\Form\SurveyType;

/**
 * Survey controller.
 *
 * @Route("/survey")
 */
class SurveyController extends Controller
{
    /**
     * Lists all Survey entities.
     *
     * @Route("/", name="survey_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $surveys = $em->getRepository('AppBundle:Survey')->findAll();

        return $this->render('survey/index.html.twig', array(
            'surveys' => $surveys,
        ));
    }

    /**
     * Creates a new Survey entity.
     *
     * @Route("/new", name="survey_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $survey = new Survey();
        $form = $this->createForm('AppBundle\Form\SurveyType', $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();

            return $this->redirectToRoute('survey_show', array('id' => $survey->getId()));
        }

        return $this->render('survey/new.html.twig', array(
            'survey' => $survey,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Survey entity.
     *
     * @Route("/{id}", name="survey_show")
     * @Method("GET")
     */
    public function showAction(Survey $survey)
    {
        $deleteForm = $this->createDeleteForm($survey);

        return $this->render('survey/show.html.twig', array(
            'survey' => $survey,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Survey entity.
     *
     * @Route("/{id}/edit", name="survey_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Survey $survey)
    {
        $deleteForm = $this->createDeleteForm($survey);
        $editForm = $this->createForm('AppBundle\Form\SurveyType', $survey);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();

            return $this->redirectToRoute('survey_edit', array('id' => $survey->getId()));
        }

        return $this->render('survey/edit.html.twig', array(
            'survey' => $survey,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Survey entity.
     *
     * @Route("/{id}", name="survey_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Survey $survey)
    {
        $form = $this->createDeleteForm($survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($survey);
            $em->flush();
        }

        return $this->redirectToRoute('survey_index');
    }

    /**
     * Creates a form to delete a Survey entity.
     *
     * @param Survey $survey The Survey entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Survey $survey)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('survey_delete', array('id' => $survey->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
