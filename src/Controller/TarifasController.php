<?php

namespace App\Controller;

use App\Entity\Tarifas;
use App\Form\TarifasType;
use App\Repository\TarifasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarifas')]
final class TarifasController extends AbstractController
{
    #[Route(name: 'app_tarifas_index', methods: ['GET'])]
    public function index(TarifasRepository $tarifasRepository): Response
    {
        return $this->render('tarifas/index.html.twig', [
            'tarifas' => $tarifasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarifas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifa = new Tarifas();
        $form = $this->createForm(TarifasType::class, $tarifa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarifa);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifas/new.html.twig', [
            'tarifa' => $tarifa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifas_show', methods: ['GET'])]
    public function show(Tarifas $tarifa): Response
    {
        return $this->render('tarifas/show.html.twig', [
            'tarifa' => $tarifa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tarifas $tarifa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarifasType::class, $tarifa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifas/edit.html.twig', [
            'tarifa' => $tarifa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifas_delete', methods: ['POST'])]
    public function delete(Request $request, Tarifas $tarifa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarifa->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tarifa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tarifas_index', [], Response::HTTP_SEE_OTHER);
    }
}
