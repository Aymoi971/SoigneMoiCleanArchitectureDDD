<?php

namespace App\Controller;

use App\Entity\Expertise;
use App\Form\ExpertiseType;
use App\Repository\ExpertiseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/expertise')]
class ExpertiseController extends AbstractController
{
    #[Route('/', name: 'app_expertise_index', methods: ['GET'])]
    public function index(ExpertiseRepository $expertiseRepository): Response
    {
        return $this->render('expertise/index.html.twig', [
            'expertises' => $expertiseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_expertise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $expertise = new Expertise();
        $form = $this->createForm(ExpertiseType::class, $expertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($expertise);
            $entityManager->flush();

            return $this->redirectToRoute('app_expertise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expertise/new.html.twig', [
            'expertise' => $expertise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expertise_show', methods: ['GET'])]
    public function show(Expertise $expertise): Response
    {
        return $this->render('expertise/show.html.twig', [
            'expertise' => $expertise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_expertise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Expertise $expertise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpertiseType::class, $expertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_expertise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expertise/edit.html.twig', [
            'expertise' => $expertise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expertise_delete', methods: ['POST'])]
    public function delete(Request $request, Expertise $expertise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expertise->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($expertise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_expertise_index', [], Response::HTTP_SEE_OTHER);
    }
}
