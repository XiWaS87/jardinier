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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CreationDevisController extends AbstractController
{
    #[Route('/creation/devis', name: 'app_creation_devis')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {


        $request = Request::createFromGlobals();


        $choix = $session->get('choix');
        $haie = $session->get('haie');
        $longueur = $session->get('longueur');
        $hauteur = $session->get('hauteur');


        $codeHaie = $doctrine->getRepository(Haie::class)->find($haie);

        $client = new Client();
        $form = $this->createFormBuilder($client)
        ->add('nom', TextType::class, array('label'=>'nom'))
        ->add('prenom', TextType::class, array('label'=>'prenom'))
        ->add('adresse', TextType::class, array('label'=>'adresse'))
        ->add('ville', TextType::class, array('label'=>'ville'))
        ->add('cp', TextType::class, array('label'=>'cp'))
        ->add('save', SubmitType::class, array('label' => 'GENERER'))
        ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $client->setTypeClient($choix);

            $entityManager->persist($client);
            $entityManager->flush();

            $devis = new Devis();
            $devis->setClient($client);
            $devis->setHaie($codeHaie);
            $devis->setLongueur($longueur);
            $devis->setHauteur($hauteur);
            $devis->setDate(new \DateTime());

            $entityManager->persist($devis);
            $entityManager->flush();


            return $this->redirectToRoute('app_acceuil', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('creation_devis/index.html.twig', 
            array('form' => $form->createView())
        );
    }
}
