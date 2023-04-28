<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
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
//    #[Route('/{newPassword}', name: 'app_accueil_password')]
    public function indexAction(string $newPassword = null, EntityManagerInterface $em): Response
    {
        $UserRepository = $em->getRepository(User::class);
        $isStrongPassword = null;
        if ($newPassword != null) {

            $passwordService = new PasswordService();
            dump($this->getUser()->getPassword());die;
            if ($passwordService->testPassword($newPassword)) {
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
