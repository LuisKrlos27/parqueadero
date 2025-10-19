<?php

namespace App\Controller;

use App\Entity\Vehiculos;
use App\Form\VehiculosType;
use App\Repository\VehiculosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vehiculos')]
final class VehiculosController extends AbstractController
{
    #[Route(name: 'app_vehiculos_index', methods: ['GET'])]
    public function index(VehiculosRepository $vehiculosRepository): Response
    {
        return $this->render('vehiculos/index.html.twig', [
            'vehiculos' => $vehiculosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehiculos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehiculo = new Vehiculos();
        $form = $this->createForm(VehiculosType::class, $vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehiculo);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculos/new.html.twig', [
            'vehiculo' => $vehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculos_show', methods: ['GET'])]
    public function show(Vehiculos $vehiculo): Response
    {
        return $this->render('vehiculos/show.html.twig', [
            'vehiculo' => $vehiculo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehiculos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehiculos $vehiculo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculosType::class, $vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculos/edit.html.twig', [
            'vehiculo' => $vehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculos_delete', methods: ['POST'])]
    public function delete(Request $request, Vehiculos $vehiculo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehiculo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vehiculo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehiculos_index', [], Response::HTTP_SEE_OTHER);
    }
}
