<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/magasin', name: 'magasin')]
class MagasinController extends AbstractController
{
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('magasin_stock');
    }

    #[Route('/stock', name: '_stock')]
    public function stockAction(EntityManagerInterface $em): Response
    {
        $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findAll();
        $args = array(
            'produits' => $products,
        );
        return $this->render('Shop/stock.html.twig', $args);
    }


}
