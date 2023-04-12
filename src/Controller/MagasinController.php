<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/magasin', name: 'magasin')]
class MagasinController extends AbstractController
{
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('magasin_stock');
    }

    //Cette action doit être ailleurs
    #[Route('/stock', name: '_stock')]
    public function stockAction(ManagerRegistry $doctrine): Response
    {
        return $this->render('Shop/stock.html.twig');
    }

    #[Route('/addpanier', name: '_addpanier')]
    public function addpanierAction(EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Product::class);
        $produits = $produitRepository->findAll();
        $args = array(
            'produits' => $produits,
        );
        return $this->render('Shop/stock.html.twig', $args);
    }

}