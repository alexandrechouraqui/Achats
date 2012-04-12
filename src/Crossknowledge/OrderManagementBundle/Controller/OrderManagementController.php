<?php

namespace Crossknowledge\OrderManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


class OrderManagementController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CrossknowledgeOrderManagementBundle:OrderManagement:index.html.twig');
    }


    public function languageAction($langue = null)
    {
        if($langue != null)
        {
            // On enregistre la langue en session
            $this->container->get('session')->setLocale($langue);
        }

        // on tente de rediriger vers la page d'origine
        $url = $this->container->get('request')->headers->get('referer');
        if(empty($url)) {
            $url = $this->container->get('router')->generate('Homapage');
        }
        return new RedirectResponse($url);
    }
}