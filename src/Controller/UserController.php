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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->findAll();
        $args = array(
            'users' => $users,
        );
        return $this->render('Users/users_list.html.twig', $args);
    }
    #[Route(
        '/delete/{id}',
        name: '_delete',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);

        dump($user);die();
        if (is_null($user))
            throw new NotFoundHttpException('erreur suppression utilisateur ' . $id);

        if ($user == $this->getUser()) {
            return $this->redirectToRoute('app_user_list');
        }


        $em->remove($user);
        $em->flush();
        $this->addFlash('info', 'Suppression de l\'utilisateur ' . $user->getName() ." ". $user->getSurname() . " (" . $user->getid() .') réussie');

        return $this->redirectToRoute('app_user_list');
    }

}
