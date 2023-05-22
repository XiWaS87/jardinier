<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Devis;

class VueDevisController extends AbstractController
{
    #[Route('/vue/devis', name: 'app_vue_devis')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $user = $this->getUser();

        $devis = $doctrine->getRepository(Devis::class)->findBy(['user' => $user]);


        return $this->render('vue_devis/index.html.twig', [
            'controller_name' => 'VueDevisController',
            'devis' => $devis,
        ]);
    }
}
