<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'app_order')]
class OrderController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $userId = $this->getUser();

        $orderRepository = $em->getRepository(Order::class);

        $userOrders = $orderRepository->findByUser($userId);

        $args = array(
            'orders' => $userOrders
        );

        return $this->render('Shop/order.html.twig', $args);
    }

    #[Route(
        '/delete item/{idOrder}',
        name: '_delete_item',
        requirements: [
            'idOrder' => '[1-9]\d*',
        ],
    )]
    public function deleteAction(int $idOrder, EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(Order::class);
        $order = $userRepository->find($idOrder);

        $productId = $order->getProduct();
        $qtt = $order->getQuantity();

        $em->remove($order);

        $productRepository = $em->getRepository(Product::class);
        $product = $productRepository->find($productId);

        $product->setQuantStock(  $product->getQuantStock() + $qtt );

        $em->flush();
        $this->addFlash('info', 'Élément supprimé');

        return $this->redirectToRoute('app_order_list');
    }


    #[Route(
        '/validate',
        name: '_validate',
    )]
    public function validateAction(EntityManagerInterface $em): Response
    {
        $orderRepository = $em->getRepository(Order::class);

        $orders = $orderRepository->findByUser($this->getUser());

        foreach ($orders as $order)
            $em->remove($order);

        $em->flush();
        $this->addFlash('info', 'Commande réussi !');

        return $this->redirectToRoute('app_order_list');
    }

    #[Route(
        '/empty',
        name: '_empty',
    )]
    public function emptyAction(EntityManagerInterface $em): Response
    {
        $orderRepository = $em->getRepository(Order::class);
        $productRepository = $em->getRepository(Product::class);

        $orders = $orderRepository->findByUser($this->getUser());



        foreach ($orders as $order)
        $qtt = $order->getQuantity();
        $product = $productRepository->find($order->getProduct());
        $product->setQuantStock(  $product->getQuantStock() + $qtt );

        $em->remove($order);

        $em->flush();
        $this->addFlash('info', 'Commande vidé');

        return $this->redirectToRoute('app_order_list');
    }
}
