<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    
    #[Route('/', name: 'default')]
    public function index(): Response
    {
        return new JsonResponse(
            [
                'action' => 'index',
                'time' => time(),
            ]
            );
    }
}
