<?php

namespace App\Controller;

use App\Services\HappyMessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function indexAction(HappyMessageService $messageGenerator): Response
    {
        $message = $messageGenerator->getHappyMessage();

        $args = array(
            'message' => $message,
        );
        return $this->render('Accueil/index.html.twig', $args);
    }

    public function menuAction(): Response
    {
        $user = $this->getUser();

        $args = array(
            'user' => $user,
        );
        return $this->render('Layouts/menu.html.twig', $args);
    }
}
