<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    #[Route('/magasin', name: 'app_magasin')]
    public function loginAction(): Response
    {
        return $this->render('Security/login.html.twig');
    }
}
