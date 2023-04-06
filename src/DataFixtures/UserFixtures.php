<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private ?UserPasswordHasherInterface $passwordHasher = null;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $em): void
    {
        /* ====================================================
         * = Utilisateurs
         * ====================================================*/
        $user = new User();
        $user
            ->setLogin('sadmin')
            ->setName('Admin')
            ->setSurname('Super')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_SUPERADMIN']);
        $hashedpassword = $this->passwordHasher->hashPassword($user, 'nimbas');
        $user->setPassword($hashedpassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setLogin('gilles')
            ->setName('Gilles')
            ->setSurname('Subrenat')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_ADMIN']);
        $hashedpassword = $this->passwordHasher->hashPassword($user, 'sellig');
        $user->setPassword($hashedpassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setLogin('rita')
            ->setName('Rita')
            ->setSurname('Zrour')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_CLIENT']);
        $hashedpassword = $this->passwordHasher->hashPassword($user, 'atir');
        $user->setPassword($hashedpassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setLogin('simon')
            ->setName('Simon')
            ->setSurname('Symfony')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_CLIENT']);
        $hashedpassword = $this->passwordHasher->hashPassword($user, 'nomis');
        $user->setPassword($hashedpassword);
        $em->persist($user);


        $em->flush();
    }
}
