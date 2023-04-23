<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Form\OrderType;
use App\Form\ProductType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/form', name: 'app_form')]
class FormController extends AbstractController
{
    #[Route('/order/add', name: '_order_add')]
    public function ajoutPanierAction(EntityManagerInterface $em, Request $request): Response
    {
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->add('send', SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($order);
            $em->flush();
            $this->addFlash('info', 'ajouté au panier');
            return $this->redirectToRoute('app_accueil');
        }

        if($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout panier incorrect');

        $args = array(
            'orderform' => $form->createView(),
        );
        return $this->render('Form/add_order.html.twig', $args);
    }

    #[Route(
        '/product/add',
        name: '_product_add',
    )]
    #[Route(
        '/product/add/{id}',
        name: '_product_update',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function ajoutProductAction(int $id = null, EntityManagerInterface $em, Request $request): Response
    {

        if ($id == null){
            $product = new Product();
            $isUpdateMode = false;
        }
        else{
            $isUpdateMode = true;
            $productRepository = $em->getRepository(Product::class);
            $product = $productRepository->find($id);
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($product);
            $em->flush();
            $this->addFlash('info', 'Produit'. $product->getLibelle() .'à été ajouté avec une quantité de' . $product->getQuantStock());
            return $this->redirectToRoute('app_accueil');
        }

        if($form->isSubmitted())
            $this->addFlash('info', 'Formulaire ajout produit incorrect');

        $args = array(
            'isUpdateMode' => $isUpdateMode,
            'productform' => $form->createView(),
        );

        return $this->render('Form/add_product.html.twig', $args);
    }
    #[Route(
    '/user/add',
    name: '_user_add',
    )]
    public function ajoutUserAction(EntityManagerInterface $em, Request $request): Response
    {
       $user = new User();

       $form = $this->createForm(UserType::class, $user);
       $form->add('Confirmer', SubmitType::class, ['label' => 'Créer']);
       $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'Création du compte réussi !');
            return $this->redirectToRoute('app_accueil');
        }

        if($form->isSubmitted()) {
            $this->addFlash('info', 'Formulaire création de compte incorrect');
            dump('caca');
        }
       $args = array(
           'userform' => $form->createView(),
       );
       return $this->render('Form/add_user.html.twig', $args);
    }

}
