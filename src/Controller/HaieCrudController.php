<?php

namespace App\Controller;

use App\Entity\Haie;
use App\Form\HaieType;
use App\Repository\HaieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/haie/crud')]
class HaieCrudController extends AbstractController
{
    #[Route('/', name: 'app_haie_crud_index', methods: ['GET'])]
    public function index(HaieRepository $haieRepository): Response
    {
        return $this->render('haie_crud/index.html.twig', [
            'haies' => $haieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_haie_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HaieRepository $haieRepository): Response
    {
        $haie = new Haie();
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $haieRepository->save($haie, true);

            return $this->redirectToRoute('app_haie_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie_crud/new.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_crud_show', methods: ['GET'])]
    public function show(Haie $haie): Response
    {
        return $this->render('haie_crud/show.html.twig', [
            'haie' => $haie,
        ]);
    }

    #[Route('/{code}/edit', name: 'app_haie_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Haie $haie, HaieRepository $haieRepository): Response
    {
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $haieRepository->save($haie, true);

            return $this->redirectToRoute('app_haie_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie_crud/edit.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Haie $haie, HaieRepository $haieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$haie->getCode(), $request->request->get('_token'))) {
            $haieRepository->remove($haie, true);
        }

        return $this->redirectToRoute('app_haie_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
