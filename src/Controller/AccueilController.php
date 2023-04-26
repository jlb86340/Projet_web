<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\PasswordService\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
#[AsController]
class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
   // #[Route('/{clearPassword}', name: 'app_accueil_password')]
    public function indexAction(string $clearPassword = null): Response
    {
        dump($clearPassword);
        $passwordService = new PasswordService();
        $user = $this->getUser();
        $isStrongPassword = null;
//        dump($user);
//        dump($passwordClear);
        if ($user != null){
            if ($passwordService->testPassword($user->getPassword())) {
                $isStrongPassword = true;
            } else {
                $isStrongPassword = false;
            }
        }
        $args = array(
            'isStrongPassword' => $isStrongPassword,
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
