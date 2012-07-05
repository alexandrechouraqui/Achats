<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crossknowledge\OrderManagementBundle\Entity\Fournisseur;
use Crossknowledge\OrderManagementBundle\Form\FournisseurType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Fournisseur controller.
 *
 */
class FournisseurController extends Controller
{
    /**
     * Lists all Fournisseur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur')->findAll();

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:index.html.twig', array(
            'entities' => $entities,
        ));
//        // On récupère le repository
//        $repository = $this->getDoctrine()
//                           ->getEntityManager()
//                           ->getRepository('Crossknowledge:Fournisseur');
//
//        // On récupère le nombre total d'articles
//       $nb_articles = $repository->getTotal();
//
//        // On définit le nombre d'articles par page
//        // (pour l'instant en dur dans le contrôleur, mais par la suite on le transformera en paramètre du bundle)
//        $nb_articles_page = 2;
//
//        // On calcule le nombre total de pages
//        $nb_pages = ceil($nb_articles/$nb_articles_page);
//
//        // On va récupérer les articles à partir du N-ième article :
//        $offset = ($page-1) * $nb_articles_page;
//
//        // Ici on a changé la condition pour déclencher une erreur 404
//        // lorsque la page est inférieur à 1 ou supérieur au nombre max.
//        if( $page < 1 OR $page > $nb_pages )
//        {
//            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
//        }
//
//        // On récupère les articles qu'il faut grâce à findBy() :
//        $entities = $repository->findBy(
//            array(),                 // Pas de critère
//            array('id' => 'desc'), // On tri par date décroissante
//            $nb_articles_page,       // On sélectionne $nb_articles_page articles
//            $offset                  // A partir du $offset ième
//        );
//
//        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:index.html.twig', array(
//            'entities' => $entities,
//            'page'     => $page,    // On transmet à la vue la page courante,
//            'nb_pages' => $nb_pages // Et le nombre total de pages.
//        ));
    }

    /**
     * Finds and displays a Fournisseur entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Fournisseur entity.
     *
     */
    public function newAction()
    {
        $entity = new Fournisseur();
        $form   = $this->createForm(new FournisseurType(), $entity);

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Fournisseur entity.
     *
     */
    public function createAction()
    {
        $entity  = new Fournisseur();
        $request = $this->getRequest();
        $form    = $this->createForm(new FournisseurType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fournisseur_show', array('id' => $entity->getId())));
            
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Fournisseur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }

        $editForm = $this->createForm(new FournisseurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Fournisseur entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }

        $editForm   = $this->createForm(new FournisseurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fournisseur_show', array('id' => $id)));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:Fournisseur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fournisseur entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:Fournisseur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fournisseur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fournisseur'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
}
