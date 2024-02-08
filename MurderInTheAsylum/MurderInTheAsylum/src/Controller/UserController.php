<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/server/user/register', name: 'user_register', methods: ['POST'])]
    public function registerUser(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $nickname = $requestData['nickname_user'] ?? null;
        $email = $requestData['email_user'] ?? null;

        // Check if nickname or email is not provided
        if (!$nickname || !$email) {
            return $this->json(['error' => 'El nickname y el correo electrónico son obligatorios'], Response::HTTP_BAD_REQUEST);
        }

        // Check if a user with the provided nickname or email already exists
        $userRepository = $this->entityManager->getRepository(Users::class);
        $existingUser = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if ($existingUser) {
            return $this->json(['error' => 'El nickname ya está registrado, elige otro'], Response::HTTP_BAD_REQUEST);
        }

        $existingEmailUser = $userRepository->findOneBy(['emailUser' => $email]);

        if ($existingEmailUser) {
            return $this->json(['error' => 'El correo electrónico ya está registrado, elige otro'], Response::HTTP_BAD_REQUEST);
        }

        // If no existing user, proceed with registration
        $user = new Users();
        $user->setNameUser($requestData['name_user'] ?? null);
        $user->setSurnameUser($requestData['surname_user'] ?? null);
        $user->setNicknameUser($nickname);
        $user->setAgeUser($requestData['age_user'] ?? null);
        $user->setEmailUser($email);
        $user->setPhoneUser($requestData['phone_user'] ?? null);
        $user->setPassword($requestData['password'] ?? null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario creado con éxito'], Response::HTTP_CREATED);
    }

    #[Route('/server/user/login', name: 'user_login', methods: ['POST'])]
    public function loginUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $nickname = $requestData['nickname_user'] ?? null;
        $password = $requestData['password'] ?? null;

        // Verificar que se proporcionó el apodo y la contraseña
        if (!$nickname || !$password) {
            return $this->json(['error' => 'Se requiere el nickname y la contraseña del usuario'], Response::HTTP_BAD_REQUEST);
        }

        $userRepository = $entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            throw new NotFoundHttpException('Usuario no encontrado');
        }

        // Validar la contraseña manualmente
        if ($user->getPassword() !== $password) {
            return $this->json(['error' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        // Si llegamos aquí, el inicio de sesión fue exitoso
        return $this->json(['message' => 'Inicio de sesión exitoso'], Response::HTTP_OK);
    }

    #[Route('/server/user/edit/{nickname}', name: 'user_edit', methods: ['PUT'])]
    public function updateUserByNickname(Request $request, $nickname): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);
    
        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el nickname: ' . $nickname);
        }
    
        $requestData = json_decode($request->getContent(), true);
    
        // Verificar y actualizar los campos proporcionados en la solicitud
        if (isset($requestData['name_user'])) {
            $user->setNameUser($requestData['name_user']);
        }
        if (isset($requestData['surname_user'])) {
            $user->setSurnameUser($requestData['surname_user']);
        }
        if (isset($requestData['age_user'])) {
            $user->setAgeUser($requestData['age_user']);
        }
        if (isset($requestData['email_user'])) {
            $user->setEmailUser($requestData['email_user']);
        }
        if (isset($requestData['phone_user'])) {
            $user->setPhoneUser($requestData['phone_user']);
        }
        if (isset($requestData['password'])) {
            $user->setPassword($requestData['password']);
        }
        if (isset($requestData['image_user'])) {
            $user->setImageUser($requestData['image_user']);
        }
    
        $this->entityManager->flush();
    
        return $this->json(['message' => 'Usuario actualizado con éxito']);
    }
    

    #[Route('/server/user/delete/{nickname}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUserByNickname($nickname): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);
    
        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el nickname: ' . $nickname);
        }
    
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    
        return $this->json(['message' => 'Usuario eliminado con éxito']);
    }
    

    #[Route('/server/user/{nickname}', name: 'user_by_nickname', methods: ['GET'])]
    public function getUserByNickname($nickname): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);
    
        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }
    
        $imageData = null;
        if ($user->getImageUser() !== null) {
            // Convertir blob a base64
            $imageData = base64_encode(stream_get_contents($user->getImageUser()));
        }
    
        $userData = [
            'id_user' => $user->getIdUser(),
            'name_user' => $user->getNameUser(),
            'surname_user' => $user->getSurnameUser(),
            'nickname_user' => $user->getNicknameUser(),
            'age_user' => $user->getAgeUser(),
            'email_user' => $user->getEmailUser(),
            'phone_user' => $user->getPhoneUser(),
            'password' => $user->getPassword(),
            'image_user' => $imageData,
        ];
    
        return $this->json($userData, Response::HTTP_OK);
    }
    
}


 //     #[Route('/server/user/{id}', name: 'user_by_id', methods: ['GET'])]
    //     public function getUserById($id): Response
    //     {
    //         $userRepository = $this->entityManager->getRepository(Users::class);
    //         $user = $userRepository->find($id);

    //         if (!$user) {
    //             return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
    //         }

    //         $imageData = null;
    //         if ($user->getImageUser() !== null) {
    //             // Convertir blob a base64
    //             $imageData = base64_encode(stream_get_contents($user->getImageUser()));
    //         }

    //         $userData = [
    //             'id_user' => $user->getIdUser(),
    //             'name_user' => $user->getNameUser(),
    //             'surname_user' => $user->getSurnameUser(),
    //             'nickname_user' => $user->getNicknameUser(),
    //             'age_user' => $user->getAgeUser(),
    //             'email_user' => $user->getEmailUser(),
    //             'phone_user' => $user->getPhoneUser(),
    //             'password' => $user->getPassword(),
    //             'image_user' => $imageData,
    //         ];

    //         return $this->json($userData, Response::HTTP_OK);
    //     }

    //    #[Route('server/user/email/{email}', name: 'user_by_email')]
    // public function getUserByEmail($email): Response
    // {
    //     $userRepository = $this->entityManager->getRepository(Users::class);
    //     $user = $userRepository->findOneBy(['emailUser' => $email]);

    //     if (!$user) {
    //         return $this->json(['error' => 'No se encontraron usuarios con ese correo electrónico'], Response::HTTP_NOT_FOUND);
    //     }

    //     $imageData = null;
    //     if ($user->getImageUser() !== null) {
    //         // Convertir blob a base64
    //         $imageData = base64_encode(stream_get_contents($user->getImageUser()));
    //     }

    //     $userData = [
    //         'id_user' => $user->getIdUser(),
    //         'name_user' => $user->getNameUser(),
    //         'surname_user' => $user->getSurnameUser(),
    //         'nickname_user' => $user->getNicknameUser(),
    //         'age_user' => $user->getAgeUser(),
    //         'email_user' => $user->getEmailUser(),
    //         'phone_user' => $user->getPhoneUser(),
    //         'password' => $user->getPassword(),
    //         'image_user' => $imageData,
    //     ];

    //     return $this->json($userData, Response::HTTP_OK);
    // }

    // #[Route('/server/user/create', name: 'user_create', methods: ['POST'])]
    // public function createUser(Request $request): Response
    // {
    //     $requestData = json_decode($request->getContent(), true);

    //     $user = new Users();
    //     $user->setNameUser($requestData['name_user'] ?? null);
    //     $user->setSurnameUser($requestData['surname_user'] ?? null);
    //     $user->setNicknameUser($requestData['nickname_user'] ?? null);
    //     $user->setAgeUser($requestData['age_user'] ?? null);
    //     $user->setEmailUser($requestData['email_user'] ?? null);
    //     $user->setPhoneUser($requestData['phone_user'] ?? null);
    //     $user->setPassword($requestData['password'] ?? null);
    //     $user->setImageUser($requestData['image_user'] ?? null);

    //     $this->entityManager->persist($user);
    //     $this->entityManager->flush();

    //     return $this->json(['message' => 'Usuario creado con éxito'], Response::HTTP_CREATED);
    // }
