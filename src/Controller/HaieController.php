<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HaieController extends AbstractController
{
    #[Route('/haie', name: 'app_haie')]
    public function index(): Response
    {
        return $this->render('haie/index.html.twig', [
            'controller_name' => 'HaieController',
        ]);
    }
}
