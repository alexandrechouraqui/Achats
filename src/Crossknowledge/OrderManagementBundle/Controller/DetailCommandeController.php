<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Crossknowledge\OrderManagementBundle\Entity\DetailCommande;
use Crossknowledge\OrderManagementBundle\Form\DetailCommandeType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * DetailCommande controller.
 *
 */
class DetailCommandeController extends Controller {

    /**
     * Lists all DetailCommande entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->findAll();

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:index.html.twig', array(
                    'entities' => $entities
                ));
    }

    /**
     * Lists all DetailCommande of one commande.
     *
     */
    public function indexByCommandeAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->findByCommande($id);
        $commande = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id);

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:indexByCommande.html.twig', array(
                    'entities' => $entities,
                    'commande' => $commande,
                    'id' => $id,
                ));
    }

    /**
     * Finds and displays a DetailCommande entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailCommande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    public function showAssignedToAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $userManager = $this->get('fos_user.user_manager');

        $userID = $userManager->findUserBy(array('username' => $user))->getId();

        $entities = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->findByAssignedTo($userID);

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:showAssignedTo.html.twig', array(
                    'entities' => $entities,
                ));
    }

    /**
     * Displays a form to create a new DetailCommande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function newAction($id_commande) {
        if ($id_commande != null) {
            $em = $this->getDoctrine()->getEntityManager();
            $commande = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id_commande);

            $entity = new DetailCommande();
            $form = $this->createForm(new DetailCommandeType(), $entity);

            return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:new.html.twig', array(
                        'commande' => $commande,
                        'entity' => $entity,
                        'form' => $form->createView()
                    ));
        } else {
            $entity = new DetailCommande();
            $form = $this->createForm(new DetailCommandeType(), $entity);

            return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView()
                    ));
        }
    }

    /**
     * Creates a new DetailCommande entity.
     * @Secure(roles="ROLE_USER, ROLE_MANAGER")
     */
    public function createAction($id_commande) {
        $entity = new DetailCommande();
        $request = $this->getRequest();
        $form = $this->createForm(new DetailCommandeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();         
            
            $commande = $em->getRepository('CrossknowledgeOrderManagementBundle:Commande')->find($id_commande);
            
            $entity->setCommande($commande);
            
            /* Enregistrement du créateur de la demande d'achat */
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setcreatedBy($user);
            
            /* Calcul du prix HT et du prix TTC */
            $prixUHT = $entity->getPrixHT();
            $tva = $entity->getTva() / 100;
            $fournisseur = $entity->getCommande()->getFournisseur();
            if (!isset($prixUHT))
            {
                $prix = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->getPrice($entity->getArticle(), $fournisseur)->getPrix();
                $prixHT = $entity->getQuantite() * $prix;
                $prixTTC = $prixHT * (1 + $tva);
                $entity->setPrixHT($prixHT);
                $entity->setPrixTTC($prixTTC);
            }
            else
            {
                $prixHT = $entity->getQuantite() * $prixUHT;
                $prixTTC = $prixHT * (1 + $tva);
                $entity->setPrixHT($prixHT);
                $entity->setPrixTTC($prixTTC);
            }

            /* Mise à jour du CA commandé et lettré du fournisseur */
            $caCom = $fournisseur->getCaCommande() + $prixHT;
            $fournisseur->setCaCommande($caCom);
            if ($entity->getLettrage() == true) {
                $caLett = $fournisseur->getCaLettre() + $prixHT;
                $fournisseur->setCaLettre($caLett);
            }
            $em->persist($fournisseur);

            /* Mise à jour du budget de la BU */
            $commande = $entity->getCommande();
            if ($commande->getTypeCommande() == 'Budget') {
                $manager = $entity->getassignedTo();
                $manager->setBudgetRestant($manager->getBudgetRestant() - $prixHT);
                $em->persist($manager);
            }

            /* Mise à jour DA/OA */
            if ($entity->getAccordBUM() == true) {
                $entity->setType('OA');
            } else {
                $entity->setType('DA');
            }

            $em->persist($entity);
            $em->flush();

            /* Envoi d'un e-mail au manager pour validation */
            $username = $this->container->get('security.context')->getToken()->getUser();
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserBy(array('username' => $username));
            $manager = $userManager->findUserBy(array('username' => $entity->getassignedTo()));
            
            if ($entity->getAccordBUM() != true)
            {
                $managerMail = $manager->getEmail();
                $recipient = $user->getEmail();
                $message = \Swift_Message::newInstance()
                        ->setSubject('Nouvelle demande d\'achat')
                        ->setFrom('achats@crossknowledge.com')
                        ->setTo($managerMail)
                        ->setCc($recipient)
                        ->setBody($this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:emailDA.txt.twig', array('name' => $username, 'entity' => $entity, 'manager' => $manager)))
                ;
                $this->get('mailer')->send($message);
            }
            elseif ($entity->getAccordBUM() == true)
            {
                $managerMail = $manager->getEmail();
                $recipient = $user->getEmail();
                $message = \Swift_Message::newInstance()
                        ->setSubject('Validation de votre demande d\'achats')
                        ->setFrom('achats@crossknowledge.com')
                        ->setTo($managerMail)
                        ->setCc($recipient)
                        ->setBody($this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:emailOA.txt.twig', array('name' => $username, 'entity' => $entity, 'manager' => $manager)))
                ;
                $this->get('mailer')->send($message);
            }
            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $entity->getId())));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

    /**
     * Displays a form to edit an existing DetailCommande entity.
     * 
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailCommande entity.');
        }

        /* On vérifie que l'utilisateur peut modifier cette demande d'achat */
        if ($this->get('security.context')->getToken()->getUser() != $entity->getcreatedBy()) {
            throw new AccessDeniedHttpException('Vous n\'avez pas les droits de modifier cettte commande');
        }

        $editForm = $this->createForm(new DetailCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * Edits an existing DetailCommande entity.
     * 
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);

        /* On vérifie que l'utilisateur peut modifier cette demande d'achat */
        if ($this->get('security.context')->getToken()->getUser() != $entity->getcreatedBy()) {
            if ($this->get('security.context')->getToken()->getUser() != $entity->getassignedTo()) {
                if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
                    throw new AccessDeniedHttpException('Vous n\'avez pas les droits de modifier cettte commande');
                }
            }
        }

        /* On récupère les anciennes valeurs pour les comparer aux nouvelles */
        $quantité = $entity->getQuantite();
        $lettrage = $entity->getLettrage();
        $accord = $entity->getAccordBUM();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailCommande entity.');
        }

        $editForm = $this->createForm(new DetailCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {

            $fournisseur = $entity->getCommande()->getFournisseur();

            /* Calcul du prix HT et du prix TTC */
            $prixUHT = $entity->getPrixHT();
            $tva = $entity->getTva() / 100;
            $fournisseur = $entity->getCommande()->getFournisseur();
            if (!isset($prixUHT))
            {
                $prix = $em->getRepository('CrossknowledgeOrderManagementBundle:Tarif')->getPrice($entity->getArticle(), $fournisseur)->getPrix();
                $prixHT = $entity->getQuantite() * $prix;
                $prixTTC = $prixHT * (1 + $tva);
                $entity->setPrixHT($prixHT);
                $entity->setPrixTTC($prixTTC);
            }
            else
            {
                $prixHT = $entity->getQuantite() * $prixUHT;
                $prixTTC = $prixHT * (1 + $tva);
                $entity->setPrixHT($prixHT);
                $entity->setPrixTTC($prixTTC);
            }

            /* Mise à jour de CA commandé */
            if ($quantité != $entity->getQuantite()) {
                $caCom = $fournisseur->getCaCommande() + ($entity->getQuantite() - $quantité) * $prix;
                $fournisseur->setCaCommande($caCom);
            }

            /* Mise à jour du CA Lettre */
            if ($entity->getLettrage() == true && $lettrage == false) {
                $caLett = $fournisseur->getCaLettre() + $prixHT;
                $fournisseur->setCaLettre($caLett);
            } else if ($lettrage == true && $entity->getLettrage() == false) {
                $caLett = $fournisseur->getCaLettre() - $quantité * $prix;
                $fournisseur->setCaLettre($caLett);
            }

            /* Enregistrement du créateur de la demande d'achat */
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setcreatedBy($user);

            /* Mise à jour DA/OA */
            if ($entity->getAccordBUM() == true) 
            {
                $entity->setType('OA');
            } 
            else 
            {
                $entity->setType('DA');
            }

            /* Mise à jour du budget du manager */
            if ($quantité != $entity->getQuantite()) {
                $manager = $entity->getassignedTo();
                $manager->setBudgetRestant($manager->getBudgetRestant() - ($entity->getQuantite() - $quantité) * $prix);
                $em->persist($manager);
            }
            
            /* Envoi de mail si accord du manager */
            if ($accord != true && $entity->getAccordBUM() == true)
            {
                $html = $this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:print.html.twig', array(
                    'entity' => $entity
                ));
                $data = $this->get('io_tcpdf')->quick_pdf($html);
                $attachement = \Swift_Attachment::newInstance($data, 'OA'.$entity->getId().'.pdf', 'application/pdf');
                
                $username = $this->container->get('security.context')->getToken()->getUser();
                $userManager = $this->get('fos_user.user_manager');
                $manager = $userManager->findUserBy(array('username' => $entity->getassignedTo()));
                $managerMail = $manager->getEmail();
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('Validation de votre demande d\'achats')
                        ->setFrom('achats@crossknowledge.com')
                        ->setTo($entity->getCreatedBy()->getEmail())
                        ->setCc($managerMail)
                        ->setBody($this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:emailOA.txt.twig', array('name' => $username, 'entity' => $entity, 'manager' => $manager)))
                        ->attach($attachement)
                ;
                $this->get('mailer')->send($message);
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $id)));
        }

        return $this->render('CrossknowledgeOrderManagementBundle:DetailCommande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * Deletes a DetailCommande entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);

//            /* On vérifie que l'utilisateur peut modifier cette demande d'achat */
//            if ($this->get('security.context')->getToken()->getUser() != $entity->getcreatedBy() || $this->get('security.context')->getToken()->getUser() != $entity->getassignedTo()) {
//                throw new AccessDeniedHttpException('Vous n\'avez pas les droits de modifier cettte commande');
//            }

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DetailCommande entity.');
            }

            /* Mise à jour du CA commandé et du CA lettré */
            $prixHT = $entity->getPrixHT();
            $fournisseur = $entity->getCommande()->getFournisseur();
            $fournisseur->setCaCommande($fournisseur->getCaCommande() - $prixHT);
            if ($entity->getLettrage() == true) {
                $fournisseur->setCaLettre($fournisseur->getLettre() - $prixHT);
            }
            $em->persist($fournisseur);

            /* Mise à jour du budget du manager */
            $manager = $entity->getassignedTo();
            $manager->setBudgetRestant($manager->getBudgetRestant() + $prixHT);
            $em->persist($manager);


            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('commande'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }
    
    /**
     * Lettre a DetailCommande entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function lettrageAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailCommande entity.');
        }
        
        if ($entity->getLettrage() == true)
        {
            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $id)));
        }
        else
        {
            $entity->setLettrage(true);
            $fournisseur = $entity->getCommande()->getFournisseur();
            $caLett = $fournisseur->getCaLettre() + $entity->getPrixHT();
            $fournisseur->setCaLettre($caLett);
            
            $em->persist($fournisseur);
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $id)));
        }  
    }
    
    /**
     * Accord a DetailCommande entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function accordAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailCommande entity.');
        }
        
        if ($entity->getAccordBUM() == true)
        {
            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $id)));
        }
        else
        {
            $entity->setAccordBUM(true);
            $entity->setType('OA');
            $manager = $entity->getassignedTo();
            $manager->setBudgetRestant($manager->getBudgetRestant() - $entity->getPrixHT());
            
            $em->persist($manager);
            $em->persist($entity);
            $em->flush();
            
            $html = $this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:print.html.twig', array(
                    'entity' => $entity
            ));
            $data = $this->get('io_tcpdf')->quick_pdf($html);
            $attachement = \Swift_Attachment::newInstance($data, 'OA'.$entity->getId().'.pdf', 'application/pdf');
            
            $username = $this->container->get('security.context')->getToken()->getUser();
            $userManager = $this->get('fos_user.user_manager');
            $manager = $userManager->findUserBy(array('username' => $entity->getassignedTo()));
            $managerMail = $manager->getEmail();
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Validation de votre demande d\'achats')
                    ->setFrom('achats@crossknowledge.com')
                    ->setTo($entity->getCreatedBy()->getEmail())
                    ->setCc($managerMail)
                    ->setBody($this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:emailOA.txt.twig', array('name' => $username, 'entity' => $entity, 'manager' => $manager)))
                    ->attach($attachement)
            ;
            $this->get('mailer')->send($message);
            
            return $this->redirect($this->generateUrl('detailcommande_show', array('id' => $id)));
        }  
    }
    
    /**
     * Fonction appeler en AJAX pour afficher dynamiquement le prix dans le formulaire de création d'une ligne de commande
     * 
     * @return Prix 
     */
    public function recherchePrixAction()
    {
        $request = $this->container->get('request');
        
        if($request->isXmlHttpRequest())
        {
            $article = '';
            $article = $request->request->get('article');
            
            $fournisseur = '';
            $fournisseur = $request->request->get('fournisseur');
            
            $tarif = '';
            if($article != '' && $fournisseur != '')
            {
                $repository = $this->getDoctrine()->getRepository('CrossknowledgeOrderManagementBundle:Tarif');

                $qb = $repository->createQueryBuilder('t');
                
                $qb->select('t.prix')
                  ->where(" t.article = :article AND t.fournisseur = :fournisseur")
                  ->setParameters(array('article'=> $article, 'fournisseur' => $fournisseur));
                try
                {
                    $query = $qb->getQuery();               
                    $tarif = $query->getSingleResult();
                }
                catch (\Doctrine\Orm\NoResultException $e){
                     $tarif = null;
                }
                
                $res = $tarif['prix'];
            }
            return new Response($res,200);
        }
    }
    
    /**
     * Fonction appeler en AJAX pour afficher dynamiquement la TVA dans le formulaire de création d'une ligne de commande
     * 
     * @return Prix 
     */
    public function rechercheTVAAction()
    {
        $request = $this->container->get('request');
        
        if($request->isXmlHttpRequest())
        {
            $article = '';
            $article = $request->request->get('article');
            
            $fournisseur = '';
            $fournisseur = $request->request->get('fournisseur');
            
            $tarif = '';
            if($article != '' && $fournisseur != '')
            {
                $repository = $this->getDoctrine()->getRepository('CrossknowledgeOrderManagementBundle:Tarif');

                $qb = $repository->createQueryBuilder('t');
                
                $qb->select('t.tva')
                  ->where(" t.article = :article AND t.fournisseur = :fournisseur")
                  ->setParameters(array('article'=> $article, 'fournisseur' => $fournisseur));
                try
                {
                    $query = $qb->getQuery();               
                    $tarif = $query->getSingleResult();
                }
                catch (\Doctrine\Orm\NoResultException $e){
                     $tarif = null;
                }
                
                $res = $tarif['tva'];
            }
            return new Response($res,200);
        }
    }
    
    /*Fonction permettant la génération des PDF*/
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('CrossknowledgeOrderManagementBundle:DetailCommande')->find($id);
        
        $html = $this->renderView('CrossknowledgeOrderManagementBundle:DetailCommande:print.html.twig', array(
                    'entity' => $entity
        ));
        
        return new Response($this->get('io_tcpdf')->quick_pdf($html),
                    200,
                    array(
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="out.pdf"',
                    ));
    }
}
