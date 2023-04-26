<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\ProductType;
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

//    #[Route('/stock', name: '_stock')]
//    public function stockAction(EntityManagerInterface $em): Response
//    {
//        $order = new Product();
//
//        $form = $this->createForm(ProductType::class, $order);
//        $orderRepository = $em->getRepository(Product::class);
//        $order = $orderRepository->findAll();
//        $args = array(
//            'produits' => $order,
//        );
//
//        return $this->render('Product/view.html.twig', $args);
//    }
}