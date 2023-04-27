<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataFixtures extends Fixture
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
        $user1 = new User();
        $user1
            ->setLogin('sadmin')
            ->setName('Admin')
            ->setSurname('Super')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_SUPERADMIN']);
        $hashedpassword = $this->passwordHasher->hashPassword($user1, 'nimbas');
        $user1->setPassword($hashedpassword);
        $em->persist($user1);

        $user2 = new User();
        $user2
            ->setLogin('gilles')
            ->setName('Gilles')
            ->setSurname('Subrenat')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_ADMIN']);
        $hashedpassword = $this->passwordHasher->hashPassword($user2, 'sellig');
        $user2->setPassword($hashedpassword);
        $em->persist($user2);

        $user3 = new User();
        $user3
            ->setLogin('rita')
            ->setName('Rita')
            ->setSurname('Zrour')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_CLIENT']);
        $hashedpassword = $this->passwordHasher->hashPassword($user3, 'atir');
        $user3->setPassword($hashedpassword);
        $em->persist($user3);

        $user4 = new User();
        $user4
            ->setLogin('simon')
            ->setName('Simon')
            ->setSurname('Symfony')
            ->setBirthdate(new \DateTime())
            ->setRoles(['ROLE_CLIENT']);
        $hashedpassword = $this->passwordHasher->hashPassword($user4, 'nomis');
        $user4->setPassword($hashedpassword);
        $em->persist($user4);

        /* ====================================================
         * = Produits
         * ====================================================*/
        $product1 = new Product();
        $product1
            -> setPrice(229)
            -> setLibelle("PC Portable Asus")
            -> setQuantStock(20);
        $em->persist($product1);

        $product2 = new Product();
        $product2
            -> setPrice(7.12)
            -> setLibelle("Pampers Culottes de Bain")
            -> setQuantStock(50);
        $em->persist($product2);

        $product3 = new Product();
        $product3
            -> setPrice(139)
            -> setLibelle("Ecran 27\" HP" )
            -> setQuantStock(10);
        $em->persist($product3);

        $product4 = new Product();
        $product4
            -> setPrice(9.50)
            -> setLibelle("Câble USB C")
            -> setQuantStock(30);
        $em->persist($product4);

        $product5 = new Product();
        $product5
            -> setPrice(35)
            -> setLibelle("Chaussures de sport")
            -> setQuantStock(100);
        $em->persist($product5);

        $product6 = new Product();
        $product6
            -> setPrice(142)
            -> setLibelle("Chaise de bureau")
            -> setQuantStock(10);
        $em->persist($product6);

        $product7 = new Product();
        $product7
            -> setPrice(99.99)
            -> setLibelle("Aspirateur Dyson")
            -> setQuantStock(5);
        $em->persist($product7);

        $product8 = new Product();
        $product8
            -> setPrice(24.99)
            -> setLibelle("Puzzle 500 pièces")
            -> setQuantStock(10);
        $em->persist($product8);

        $product9 = new Product();
        $product9
            -> setPrice(99.99)
            -> setLibelle("Toboggan Vert")
            -> setQuantStock(5);
        $em->persist($product9);

        $em->flush();



    }
}
