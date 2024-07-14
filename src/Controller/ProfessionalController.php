<?php

namespace App\Controller;

use App\Entity\Professional;
use App\Form\ProfessionalType;
use App\Repository\ProfessionalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/professional')]
class ProfessionalController extends AbstractController
{
    #[Route('/', name: 'app_professional_index', methods: ['GET'])]
    public function index(ProfessionalRepository $professionalRepository): Response
    {
        return $this->render('professional/index.html.twig', [
            'professionals' => $professionalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professional_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professional = new Professional();
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professional);
            $entityManager->flush();

            return $this->redirectToRoute('app_professional_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professional/new.html.twig', [
            'professional' => $professional,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professional_show', methods: ['GET'])]
    public function show(Professional $professional): Response
    {
        return $this->render('professional/show.html.twig', [
            'professional' => $professional,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professional_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professional $professional, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professional_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professional/edit.html.twig', [
            'professional' => $professional,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professional_delete', methods: ['POST'])]
    public function delete(Request $request, Professional $professional, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professional->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($professional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professional_index', [], Response::HTTP_SEE_OTHER);
    }
}
