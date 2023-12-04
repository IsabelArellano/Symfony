<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;

use Symfony\Component\HttpFoundation\JsonResponse;

class AboutUsContactController extends AbstractController
{
    // ...

    private function getMessagesByType(ManagerRegistry $managerRegistry, string $type): array
    {
        $mensaje_repo = $managerRegistry->getRepository(Message::class);
        $messages = $mensaje_repo->findBy(['code_message' => $type]);

        return $messages;
    }

  
#[Route('/aboutUs', name: 'aboutUs')]
public function getAboutUs(ManagerRegistry $managerRegistry): JsonResponse
{
    $aboutUsMessages = $this->getMessagesByType($managerRegistry, 'aboutus');

    return $this->json([
        'controller_name' => 'AboutUsContactController',
        'messages' => $aboutUsMessages,
    ]);
}

#[Route('/contact', name: 'contact')]
public function getContact(ManagerRegistry $managerRegistry): JsonResponse
{
    $contactMessages = $this->getMessagesByType($managerRegistry, 'contact');

    return $this->json([
        'controller_name' => 'AboutUsContactController',
        'messages' => $contactMessages,
    ]);
}
}




