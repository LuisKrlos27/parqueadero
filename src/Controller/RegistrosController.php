<?php

namespace App\Controller;

use App\Entity\Registros;
use App\Form\RegistrosType;
use App\Repository\RegistrosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/registros')]
final class RegistrosController extends AbstractController
{
    #[Route(name: 'app_registros_index', methods: ['GET'])]
    public function index(RegistrosRepository $registrosRepository): Response
    {
        return $this->render('registros/index.html.twig', [
            'registros' => $registrosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_registros_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $registro = new Registros();
        $form = $this->createForm(RegistrosType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registro);
            $entityManager->flush();

            return $this->redirectToRoute('app_registros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registros/new.html.twig', [
            'registro' => $registro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_registros_show', methods: ['GET'])]
    public function show(Registros $registro): Response
    {
        return $this->render('registros/show.html.twig', [
            'registro' => $registro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_registros_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Registros $registro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrosType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_registros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registros/edit.html.twig', [
            'registro' => $registro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_registros_delete', methods: ['POST'])]
    public function delete(Request $request, Registros $registro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$registro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($registro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_registros_index', [], Response::HTTP_SEE_OTHER);
    }
}
