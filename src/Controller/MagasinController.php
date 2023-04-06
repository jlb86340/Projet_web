<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/stock', name: '_stock')]
    public function stockAction(EntityManagerInterface $em): Response
    {
        if (isset($_POST['ajouter'])) {
            $panier = $em->getRepository('App:Order')->find($this->getParameter('id_user'));
            $panier-> setUserId($em->getRepository('App:User')->find($this->getParameter('id_user')));

            dump($panier);

            $em->persist($panier);
            $em->flush();

            $args = array(
                "produit_quantStock" => $_POST['ajouter'],
            );
            return $this->redirectToRoute('magasin_stock', $args);
        }
        $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findAll();
        $args = array(
            'produits' => $products,
        );
        return $this->render('Shop/stock.html.twig', $args);
    }

    #[Route('/addpanier', name: '_addpanier')]
    public function addpanierAction(EntityManagerInterface $em, Request $request): Response
    {
        $order = new Order();

        $form = $this->createForm();
        $user = $this->getUser()->getUserIdentifier();
        $product = $order->getProduct()->getId();
        $quantity = count($em->getRepository("App:Order")->findAll());

        $order->getQuantity();
        $args = array(
            'user' => $user,
            'product' => $product,
            'quantity' => $quantity
        );
        return $this->render('Shop/stock.html.twig', $args);
    }

}