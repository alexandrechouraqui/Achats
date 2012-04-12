<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crossknowledge\OrderManagementBundle\Entity\Commande;
use Crossknowledge\OrderManagementBundle\Form\CommandeType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all Commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->findAll();
        
        foreach ($entities as $entity)
        {
            $id = $entity->getId();
            $lignes = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->findByCommande($id);
            $nb = count($lignes);
            $nbOA = 0;

            foreach ( $lignes as $ligne)
            {
                if ($ligne->getType() == 'OA')
                {
                    $nbOA++;
                }
            }
            if ($nb == $nbOA && $nb!=0)
            {
                $entity->setTypeOA('OA');
            }
            else
            {
                $entity->setTypeOA('DA');
            }
            $em->persist($entity);
            $em->flush();
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Commande entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Commande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function newAction()
    {
        $entity = new Commande();
        $form   = $this->createForm(new CommandeType(), $entity);

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Commande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function createAction()
    {
        $entity  = new Commande();
        $request = $this->getRequest();
        $form    = $this->createForm(new CommandeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commande_show', array('id' => $entity->getId())));
            
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Commande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $editForm = $this->createForm(new CommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Commande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $editForm   = $this->createForm(new CommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commande_show', array('id' => $id)));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Commande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Commande entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Commande entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('commande'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
