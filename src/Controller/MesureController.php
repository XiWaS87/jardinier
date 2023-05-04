<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Haie;
use Symfony\Component\HttpFoundation\Request;


class MesureController extends AbstractController
{
    #[Route('/mesure', name: 'app_mesure')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $request = Request::createFromGlobals();
        $choix=$request->get('choix');
        
        $session = new Session();
        $session->set('choix', $choix);


        $lesHaies = $doctrine->getRepository(Haie::class)->findAll();

        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'MesureController',
            'lesHaies' => $lesHaies 
        ]);
    }
}
