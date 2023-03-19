<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function indexAction(): Response
    {
        return $this->render('Accueil/index.html.twig');
    }

    public function menuAction(): Response
    {
        $args = array(
        );
        return $this->render('Layouts/menu.html.twig', $args);
    }
}
