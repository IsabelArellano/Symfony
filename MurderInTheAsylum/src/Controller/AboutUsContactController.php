<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;


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
    public function getAboutUs(ManagerRegistry $managerRegistry): Response
    {
        $aboutUsMessages = $this->getMessagesByType($managerRegistry, 'aboutus');

        return $this->render('about_us_contact/index.html.twig', [
            'controller_name' => 'AboutUsContactController',
            'messages' => $aboutUsMessages,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function getContact(ManagerRegistry $managerRegistry): Response
    {
        $contactMessages = $this->getMessagesByType($managerRegistry, 'contact');

        return $this->render('about_us_contact/index.html.twig', [
            'controller_name' => 'AboutUsContactController',
            'messages' => $contactMessages,
        ]);
    }
}




