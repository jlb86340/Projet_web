<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProduitController.php',
        ]);
    }

    #[Route('/produit/add', name: 'add_produit')]
    public function produitAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->add('send', SubmitType::class, ['label' => 'add Product']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($product);
            $em->flush();
            $this->addFlash('info', 'ajout du produit réussie');
            return $this->redirectToRoute('app_accueil');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire produit incorrect');
        dump($_POST);

        $args = array(
            'myform' => $form->createView(),
        );


        return $this->render('Form/add_product.html.twig', $args);
    }
}
