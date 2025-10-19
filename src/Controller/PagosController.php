<?php

namespace App\Controller;

use App\Entity\Pagos;
use App\Form\PagosType;
use App\Repository\PagosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pagos')]
final class PagosController extends AbstractController
{
    #[Route(name: 'app_pagos_index', methods: ['GET'])]
    public function index(PagosRepository $pagosRepository): Response
    {
        return $this->render('pagos/index.html.twig', [
            'pagos' => $pagosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pagos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pago = new Pagos();
        $form = $this->createForm(PagosType::class, $pago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pago);
            $entityManager->flush();

            return $this->redirectToRoute('app_pagos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pagos/new.html.twig', [
            'pago' => $pago,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pagos_show', methods: ['GET'])]
    public function show(Pagos $pago): Response
    {
        return $this->render('pagos/show.html.twig', [
            'pago' => $pago,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pagos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pagos $pago, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PagosType::class, $pago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pagos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pagos/edit.html.twig', [
            'pago' => $pago,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pagos_delete', methods: ['POST'])]
    public function delete(Request $request, Pagos $pago, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pago->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pago);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pagos_index', [], Response::HTTP_SEE_OTHER);
    }
}
