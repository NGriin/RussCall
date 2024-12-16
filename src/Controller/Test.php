<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class Test extends AbstractController
{
    #[Route('/test', name: 'app_conference')]
    public function index(): Response
    {
        return $this->json('RussCall?');
    }
}