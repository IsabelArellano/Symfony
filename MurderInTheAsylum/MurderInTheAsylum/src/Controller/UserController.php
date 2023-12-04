<?php

namespace App\Controller;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user', name: 'user')]
    public function getUsers(): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $users = $userRepository->findAll();

        // Obtener datos utilizando los getters
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id_user' => $user->getIdUser(),
                'name_user' => $user->getNameUser(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ];
        }

        
     // return $this->render('user/index.html.twig', [
        //     'controller_name' => 'UserController',
        //     'users' => $data,
        // ]);

        return $this->json($data, Response::HTTP_OK);
    }


    #[Route('/user/create', name: 'user_create')]
    public function createUser(Request $request): Response
    {
        // Obtener los datos del formulario o del JSON enviado
        $requestData = json_decode($request->getContent(), true);

        // Crear una nueva instancia de Users utilizando los setters
        $user = new Users();
        $user->setNameUser($requestData['id_user'] ?? null);
        $user->setNameUser($requestData['name_user'] ?? null);
        $user->setEmail($requestData['email'] ?? null);
        $user->setPassword($requestData['password'] ?? null);

        // Persistir el objeto y enviarlo a la base de datos
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Devolver una respuesta JSON indicando éxito
        return $this->json(['message' => 'Usuario creado con éxito'], Response::HTTP_CREATED);
    }

    #[Route('/user/update/{id}', name: 'user_update')]
    public function updateUser(Request $request, int $id): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);

        // Buscar el usuario por su ID
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$id);
        }

        // Obtener los datos del formulario o del JSON enviado
        $requestData = json_decode($request->getContent(), true);

        // Actualizar los datos del usuario existente utilizando los setters
        $user->setNameUser($requestData['name_user'] ?? $user->getNameUser());
        $user->setEmail($requestData['email'] ?? $user->getEmail());
        $user->setPassword($requestData['password'] ?? $user->getPassword());

        // Persistir los cambios en la base de datos
        $this->entityManager->flush();

        // Devolver una respuesta JSON indicando éxito
        return $this->json(['message' => 'Usuario actualizado con éxito']);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function deleteUser(int $id): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);

        // Buscar el usuario por su ID
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$id);
        }

        // Eliminar el usuario seleccionado
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        // Devolver una respuesta JSON indicando éxito
        return $this->json(['message' => 'Usuario eliminado con éxito']);
    }
}



?>