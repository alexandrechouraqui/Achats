<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crossknowledge\OrderManagementBundle\Entity\Tarif;
use Crossknowledge\OrderManagementBundle\Form\TarifType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tarif controller.
 *
 */
class TarifController extends Controller
{
    /**
     * Lists all Tarif entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->findAll();

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Tarif entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarif entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Tarif entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $entity = new Tarif();
        $form   = $this->createForm(new TarifType(), $entity);

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Tarif entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        $entity  = new Tarif();
        $request = $this->getRequest();
        $form    = $this->createForm(new TarifType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tarif_show', array('id' => $entity->getId())));
            
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Tarif entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarif entity.');
        }

        $editForm = $this->createForm(new TarifType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Tarif entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarif entity.');
        }

        $editForm   = $this->createForm(new TarifType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tarif_show', array('id' => $id)));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Tarif:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tarif entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tarif entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tarif'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function rechercheDeviseAction()
    {
        $request = $this->container->get('request');
        
        if($request->isXmlHttpRequest())
        {
            $fournisseur = '';
            $fournisseur = $request->request->get('fournisseur');
            
            $devise = '';
            if($fournisseur != '')
            {
                $repository = $this->getDoctrine()->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur');

                $qb = $repository->createQueryBuilder('f');
                
                $qb->select('f.devise')
                  ->where("f.id = :fournisseur")
                  ->setParameter('fournisseur', $fournisseur);
                
                try
                {
                    $query = $qb->getQuery();               
                    $devise = $query->getSingleResult();
                }
                catch (\Doctrine\Orm\NoResultException $e){
                     $devise = null;
                }
                
                $res = $devise['devise'];
            }
            return new Response($res,200);
        }
    }
}
