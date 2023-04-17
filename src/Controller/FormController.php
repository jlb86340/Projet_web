<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/form', name: 'app_form')]
class FormController extends AbstractController
{
    #[Route('/order/add', name: '_order_add')]
    public function ajoutPanierAction(int $id, EntityManagerInterface $em): Response
    {
        $quantityRepository = $em->getRepository(Product::class);
        $order = $quantityRepository->find($id);

        $form = $this->createForm(OrderType::class, $order);
        $form->add('send', SubmitType::class, ['label' => 'Ajouter au panier']);

        $args = array(
            'orderform' => $form->createView(),
        );
        return $this->render('Form/add_order.html.twig', $args);
    }
}
