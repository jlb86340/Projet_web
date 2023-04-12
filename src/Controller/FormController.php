<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/form', name: 'app_form')]
    public function ajoutPanierAction(int $id, EntityManagerInterface $em): Response
    {
        $quantityRepository = $em->getRepository(Product::class);
        $product = $quantityRepository->find($id);


        return $this->render();
    }
}
