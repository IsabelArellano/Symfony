<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/server/message/endgame', name: 'app_message_endgame', methods: ['GET'])]
    public function endgame(): JsonResponse
    {
        // Obtener el repositorio de la entidad Message
        $repository = $this->entityManager->getRepository(Message::class);

        // Obtener el mensaje
        $message = $repository->findOneBy([]);

        // Si no se encuentra ningún mensaje, devolver una respuesta de error
        if (!$message) {
            return $this->json(['error' => 'No se encontró ningún mensaje en la base de datos.'], 404);
        }

        // Crear el array de datos para la respuesta JSON
        $responseData = [
            'id_message' => $message->getIdMessage(),
            'body_message' => $message->getBodyMessage(),
            // Agrega más campos si es necesario
        ];

        // Devolver la respuesta JSON con el mensaje y el código de estado 200 (OK)
        return $this->json($responseData);
    }
}

