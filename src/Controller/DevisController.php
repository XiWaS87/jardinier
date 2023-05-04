<?php

namespace App\Controller;

use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();

        $session = new Session();
        $choix = $session->get('choix');

        $codeHaie = $request->get('haie');
        $longueur = $request->get('longueur');
        $hauteur = $request->get('hauteur');
       
        $type = $session->set('haie', $codeHaie);
        $longueursession = $session->set('longueur', $longueur);
        $hauteursession = $session->set('hauteur', $hauteur);


       

        $prix = $doctrine->getRepository(Haie::class)->find($codeHaie)->getPrix();
         
        $maHaie = $doctrine->getRepository(Haie::class)->find($codeHaie);


        


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'choix' => $choix,
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'prix' => $prix,
            'maHaie' => $maHaie,
        ]);
    }
}
