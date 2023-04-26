<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'app_order')]
class OrderController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $orderRepository = $em->getRepository(Order::class);
        $order = $orderRepository->findAll();
        $args = array(
            'orders' => $order,
        );

        return $this->render('Shop/order.html.twig', $args);    }
}
