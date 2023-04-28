<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit', name: 'produit')]
class ProduitController extends AbstractController
{

    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('produit_list');
    }

    #[Route('/add', name: '_add')]
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
            $this->addFlash('isAdded', 'Ajout du produit réussie');
            return $this->render('Form/add_product.html.twig');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire produit incorrect');

        $args = array(
            'myform' => $form->createView(),
        );


        return $this->render('Form/add_product.html.twig', $args);
    }
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findAll();
        $args = array(
            'produits' => $products,
        );
        return $this->render('Product/listing.html.twig', $args);
    }

    #[Route(
        '/view/{id}',
        name: '_view',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function viewAction(int $id, EntityManagerInterface $em): Response
    {
        $productRepository = $em->getRepository(Product::class);
        $product = $productRepository->find($id);

        if (is_null($product))
        {
            $this->addFlash('info', 'view : product ' . $id . ' inexistant');
            return $this->redirectToRoute('produit_list');
        }

        $args = array(
            'produit' => $product,
        );
        return $this->render('Product/view.html.twig', $args);
    }

    #[Route(
        '/delete/{id}',
        name: '_delete',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $productRepository = $em->getRepository(Product::class);
        $product = $productRepository->find($id);

        if (is_null($product))
            throw new NotFoundHttpException('erreur suppression produit ' . $id);

        $em->remove($product);
        $em->flush();
        $this->addFlash('info', 'suppression produit ' . $id . ' réussie');

        return $this->redirectToRoute('produit_list');
    }
}
