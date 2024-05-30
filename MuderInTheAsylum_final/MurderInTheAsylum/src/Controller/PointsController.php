<?php


namespace App\Controller;

use App\Entity\Items;
use App\Entity\Points;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GMP;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/server/points/calculate', name: 'calculate_points', methods: ['POST'])]
    public function calculatePoints(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $nickname = $requestData['nickname_user'] ?? null;
        $itemsCollected = $requestData['items_collected'] ?? null;

        if (!$nickname || !$itemsCollected || !is_array($itemsCollected)) {
            return new JsonResponse(['error' => 'Nickname and items collected are required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $totalPoints = 0;
        $itemsRepository = $this->entityManager->getRepository(Items::class);

        foreach ($itemsCollected as $itemName) {
            $item = $itemsRepository->findOneBy(['nameItem' => $itemName]);
            if ($item) {
                $totalPoints += $item->getPunctuation();
            } else {
                return new JsonResponse(['error' => "Item $itemName not found"], JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        // Update or create points entry for the user
        $pointsRepository = $this->entityManager->getRepository(Points::class);
        $points = $pointsRepository->findOneBy(['idUser' => $user]);

        if (!$points) {
            $points = new Points();
            $points->setIdUser($user);
            $points->setPoints($totalPoints);
            $this->entityManager->persist($points);
        } else {
            $points->setPoints($points->getPoints() + $totalPoints);
        }

        $this->entityManager->flush();

        return new JsonResponse(['points' => $points->getPoints()], JsonResponse::HTTP_OK);
    }

    #[Route('/server/points/user/{nickname}', name: 'get_user_points', methods: ['GET'])]
    public function getUserPoints(string $nickname): JsonResponse
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['nicknameUser' => $nickname]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $pointsRepository = $this->entityManager->getRepository(Points::class);
        $points = $pointsRepository->findOneBy(['idUser' => $user]);

        if (!$points) {
            return new JsonResponse(['points' => 0], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['points' => $points->getPoints()], JsonResponse::HTTP_OK);
    }


}

