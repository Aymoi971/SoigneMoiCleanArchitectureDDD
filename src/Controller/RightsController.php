<?php

namespace App\Controller;

use App\Entity\Rights;
use App\Form\RightsType;
use App\Repository\RightsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rights')]
class RightsController extends AbstractController
{
    #[Route('/', name: 'app_rights_index', methods: ['GET'])]
    public function index(RightsRepository $rightsRepository): Response
    {
        return $this->render('rights/index.html.twig', [
            'rights' => $rightsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $right = new Rights();
        $form = $this->createForm(RightsType::class, $right);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($right);
            $entityManager->flush();

            return $this->redirectToRoute('app_rights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rights/new.html.twig', [
            'right' => $right,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rights_show', methods: ['GET'])]
    public function show(Rights $right): Response
    {
        return $this->render('rights/show.html.twig', [
            'right' => $right,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rights_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rights $right, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RightsType::class, $right);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rights/edit.html.twig', [
            'right' => $right,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rights_delete', methods: ['POST'])]
    public function delete(Request $request, Rights $right, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$right->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($right);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rights_index', [], Response::HTTP_SEE_OTHER);
    }
}
