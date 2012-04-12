<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crossknowledge\OrderManagementBundle\Entity\Article;
use Crossknowledge\OrderManagementBundle\Form\ArticleType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:Article')->findAll();

        return $this->render('CrossknowledgeOrderManagementBundle:Article:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Article:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Article entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $entity = new Article();
        $form   = $this->createForm(new ArticleType(), $entity);

        return $this->render('CrossknowledgeOrderManagementBundle:Article:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Article entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        $entity  = new Article();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArticleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('article_show', array('id' => $entity->getId())));
            
        }
             
        return $this->render('CrossknowledgeOrderManagementBundle:Article:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Article:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Article entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm   = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('article_show', array('id' => $id)));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Article:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Article')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('article'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
