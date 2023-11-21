<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function getUsers(ManagerRegistry  $managerRegistry): Response
    {
        $user_repo = $managerRegistry->getRepository(Users::class);
        $users = $user_repo->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' =>$users
        ]);
    }
}
