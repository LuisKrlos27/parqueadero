<?php

namespace App\Controller;

use App\Entity\TiposVehiculos;
use App\Form\TiposVehiculosType;
use App\Repository\TiposVehiculosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tipos/vehiculos')]
final class TiposVehiculosController extends AbstractController
{
    #[Route(name: 'app_tipos_vehiculos_index', methods: ['GET'])]
    public function index(TiposVehiculosRepository $tiposVehiculosRepository): Response
    {
        return $this->render('tipos_vehiculos/index.html.twig', [
            'tipos_vehiculos' => $tiposVehiculosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tipos_vehiculos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tiposVehiculo = new TiposVehiculos();
        $form = $this->createForm(TiposVehiculosType::class, $tiposVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tiposVehiculo);
            $entityManager->flush();

            return $this->redirectToRoute('app_tipos_vehiculos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipos_vehiculos/new.html.twig', [
            'tipos_vehiculo' => $tiposVehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tipos_vehiculos_show', methods: ['GET'])]
    public function show(TiposVehiculos $tiposVehiculo): Response
    {
        return $this->render('tipos_vehiculos/show.html.twig', [
            'tipos_vehiculo' => $tiposVehiculo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tipos_vehiculos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TiposVehiculos $tiposVehiculo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TiposVehiculosType::class, $tiposVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tipos_vehiculos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipos_vehiculos/edit.html.twig', [
            'tipos_vehiculo' => $tiposVehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tipos_vehiculos_delete', methods: ['POST'])]
    public function delete(Request $request, TiposVehiculos $tiposVehiculo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tiposVehiculo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tiposVehiculo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tipos_vehiculos_index', [], Response::HTTP_SEE_OTHER);
    }
}
