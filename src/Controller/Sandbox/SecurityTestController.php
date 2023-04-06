<?php

namespace App\Controller\Sandbox;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/sandbox/securitytest', name: 'sandbox_securitytest')]
class SecurityTestController extends AbstractController
{
    #[Route('/addusers', name: '_addusers')]
    public function addUsersAction(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user
            ->setLogin('Kimito')
            ->setRoles(['ROLE_SUPERADMIN']);
        $hashedPassword = $passwordHasher->hashPassword($user, 'toto');
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();

        return new Response('<body></body>');
    }
}
