<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientProcessesController extends AbstractController
{
    #[Route('/client/processes', name: 'app_client_processes')]
    public function index(): Response
    {
        
        return $this->render('client_processes/index.html.twig', [
            'controller_name' => 'ClientProcessesController',
        ]);
    }
}
