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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/form', name: 'app_form')]
class FormController extends AbstractController
{
    #[Route('/order/add', name: '_order_add')]
    #[Route('/order/add/{idProduit}', name: '_order_add')]
    public function ajoutPanierAction(EntityManagerInterface $em, Request $request, $idProduit = null): Response
    {

        $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findAll();
        $forms = [];

        foreach($products as $product) {

            $order = new Order();
            $form = $this->createForm(OrderType::class, $order);
            $form->add('send', SubmitType::class, [
                'label' => 'Ajouter' ,
                'attr' => [
                    'value' => $product->getId()
                ]
                ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $order->setUser($this->getUser());
                $order->setProduct($product);
                $product->setQuantStock($product->getQuantStock() - $order->getQuantity());
                $em->persist($order);

                $em->flush();
                $this->addFlash('info', 'ajouté au panier');
                return $this->redirectToRoute('app_form_order_add');
            }
            $forms[$product->getId()] = $form->createView();


            if ($form->isSubmitted())
                $this->addFlash('info', 'formulaire ajout panier incorrect');
        }


        $args = array(
            'forms' => $forms,
            'produits' => $products,
        );
        return $this->render('Product/view.html.twig', $args);
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
    #[Route(
        '/user/update/{id}',
        name: '_user_update',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function ajoutUserAction(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $id = $request->get('id');
        if ($id == null) {
            $user = new User();
            $isUpdateMode = false;

            if (!is_null($this->getUser())) {
                if ($this->getUser()->getRoles()[0] == "ROLE_SUPERADMIN") {
                    $user->setRoles(["ROLE_ADMIN"]);
                } else {
                    $user->setRoles(["ROLE_CLIENT"]);
                }
            }
        }
        else{
            $isUpdateMode = true;
            $userRepository = $em->getRepository(User::class);
            $user = $userRepository->find($id);
        }

       $form = $this->createForm(UserType::class, $user);
       $form->add('Confirmer', SubmitType::class, ['label' => 'Créer']);
       $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $user->getPassword();
            $userRepository = $em->getRepository(User::class);
            $isSamePassword = $userRepository->findOneBy(['password' => $password]);
            if (!$isSamePassword) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                );
                $user->setPassword($hashedPassword);
                $em->persist($user);
                $em->flush();
                $this->addFlash('info', 'Création du compte réussi !');
            }


            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'Création du compte réussi !');
            return $this->redirectToRoute('app_accueil');
        }

        if($form->isSubmitted()) {
            $this->addFlash('info', 'Formulaire création de compte incorrect');
        }

       $args = array(
           'isUpdateMode' => $isUpdateMode,
           'userform' => $form->createView(),
       );
       return $this->render('Form/add_user.html.twig', $args);
    }
}
