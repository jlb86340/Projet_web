<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VenteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product();
        $product1
            ->setDenomination('voiture')
            ->setCode('7 11 654 876')
            ->setDateCreation(new \DateTime())
            ->setActif(true)
            ->setDescriptif('descriptif 11111');
        $em->persist($product1);

        $produit2 = new Product();
        $produit2
            ->setDenomination('skate')
            ->setCode('5 21 749 559')
            ->setDateCreation(new \DateTime())
            ->setActif(true)
            ->setDescriptif('descriptif 22222');
        // il faudra ici associer le manuel2 au produit2
        $em->persist($produit2);


        $manager->flush();
    }
}
