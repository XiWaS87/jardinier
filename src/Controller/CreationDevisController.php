<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Devis;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use App\Entity\Haie;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CreationDevisController extends AbstractController
{
    #[Route('/creation/devis', name: 'app_creation_devis')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {


        $request = Request::createFromGlobals();

        $entityManager = $doctrine->getManager();

        $choix = $session->get('choix');             // On utilise les get pour obtenir les données de l'id de l'input voulue
        $haie = $session->get('haie');
        $hauteur = $session->get('hauteur');
        $longueur = $session->get('longueur');

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));

            $typeClient = $monUser->getTypeClient();
        } else {
            $typeClient = '';
        }

        $codehaie = $doctrine->getRepository(Haie::class)->find($haie);

        $devis = new Devis();
        $devis->setUser($monUser);
        $devis->setHaie($codehaie);
        $devis->setLongueur($longueur);
        $devis->setHauteur($hauteur);
        $devis->setDate(new \DateTime());

        $entityManager->persist($devis);
        $entityManager->flush();



        return $this->render('creation_devis/index.html.twig', [
            'controller_name' => 'CreationDevisController',
            'user' => $monUser,
        ]);
    }
}
