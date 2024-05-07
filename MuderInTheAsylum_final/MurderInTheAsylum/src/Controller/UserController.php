<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/server/user/register', name: 'user_register', methods: ['POST'])]
    public function registerUser(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $nickname = $requestData['nickname_user'] ?? null;
        $email = $requestData['email_user'] ?? null;
        $password = $requestData['password'] ?? null;

        // Comprobar si no se proporciona el apodo, el correo electrónico o la contraseña
        if (!$nickname || !$email || !$password) {
            return $this->json(['error' => 'El apodo, el correo electrónico y la contraseña son obligatorios'], Response::HTTP_BAD_REQUEST);
        }

        // Comprobar si ya existe un usuario con el apodo o correo electrónico proporcionados
        $userRepository = $this->entityManager->getRepository(User::class);

        $existingUser = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if ($existingUser) {
            return $this->json(['error' => 'El apodo ya está registrado, elige otro'], Response::HTTP_BAD_REQUEST);
        }

        $existingEmailUser = $userRepository->findOneBy(['emailUser' => $email]);

        if ($existingEmailUser) {
            return $this->json(['error' => 'El correo electrónico ya está registrado, elige otro'], Response::HTTP_BAD_REQUEST);
        }

        // Si no existe un usuario existente, proceder con el registro
        $user = new User();
        $user->setNameUser($requestData['name_user'] ?? null);
        $user->setSurnameUser($requestData['surname_user'] ?? null);
        $user->setNicknameUser($nickname);
        $user->setAgeUser($requestData['age_user'] ?? null);
        $user->setEmailUser($email);
        $user->setPhoneUser($requestData['phone_user'] ?? null);
        $user->setPassword($password);

        // Manejar la imagen del usuario
        if ($request->files->has('image_user')) {
            $imageFile = $request->files->get('image_user');
            $imageData = file_get_contents($imageFile->getPathname());
            $user->setImageUser($imageData);
        }

        // Establecer el tipo de usuario predeterminado como 0 (usuario normal)
        $user->setTypeUser(0);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario creado con éxito'], Response::HTTP_CREATED);
    }



    #[Route('/server/user/login', name: 'user_login', methods: ['POST'])]
    public function loginUser(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $nickname = $requestData['nickname_user'] ?? null;
        $password = $requestData['password'] ?? null;

        // Verificar que se proporcionó el apodo y la contraseña
        if (!$nickname || !$password) {
            return $this->json(['error' => 'Se requiere el apodo y la contraseña del usuario'], Response::HTTP_BAD_REQUEST);
        }

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Validar la contraseña sin hashear
        if ($user->getPassword() !== $password) {
            return $this->json(['error' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener el tipo de usuario
        $userTypeValue = $user->getTypeUser() ? 'admin' : 'normal';

        // Obtener los datos del usuario y manejar la imagen
        $userData = [
            'id_user' => $user->getIdUser(),
            'name_user' => $user->getNameUser(),
            'surname_user' => $user->getSurnameUser(),
            'nickname_user' => $user->getNicknameUser(),
            'age_user' => $user->getAgeUser(),
            'email_user' => $user->getEmailUser(),
            'phone_user' => $user->getPhoneUser(),
            'password' => $user->getPassword(),
            'image_user' => $user->getImageUser() ? base64_encode(stream_get_contents($user->getImageUser())) : null,
            'user_type' => $userTypeValue,
        ];

        return $this->json(['message' => 'Inicio de sesión exitoso', 'user' => $userData], Response::HTTP_OK);
    }


    #[Route('/server/user/edit/{nickname}', name: 'user_edit', methods: ['PUT'])]
    public function updateUserByNickname(Request $request, $nickname): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el apodo: ' . $nickname);
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
            $user->setPassword($this->passwordHasher->hashPassword($user, $requestData['password']));
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
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el apodo: ' . $nickname);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario eliminado con éxito']);
    }

    #[Route('/server/user/get', name: 'get_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(User::class);

        // Obtener todos los usuarios
        $users = $userRepository->findAll();
        // Obtener todos los usuarios
        $users = $userRepository->findAll();

        // Array para almacenar los detalles de los usuarios
        $userDetails = [];

        // Recorrer todos los usuarios y almacenar sus detalles
        foreach ($users as $user) {
            $userDetails[] = [
                'nickname' => $user->getNicknameUser(),
                'type' => $user->getTypeUser() ? 'admin' : 'normal' // Suponiendo que 1 representa 'admin' y 0 representa 'normal'
                // Ajusta la lógica según tu implementación real
            ];
        }

        // Devolver los detalles de los usuarios en formato JSON
        return new JsonResponse($userDetails, Response::HTTP_OK);
    }
}
