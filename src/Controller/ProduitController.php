<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function produitAddAction(EntityManagerInterface $em): Response
    {
        $product = new Product();

        $form = $this->createForm(FilmType::class, $product);
        $form->add('send', SubmitType::class, ['label' => 'add Product']);

        $args = array(
            'myform' => $form->createView(),
        );


        return $this->render('Form/add_product.html.twig', $args);
    }
}
