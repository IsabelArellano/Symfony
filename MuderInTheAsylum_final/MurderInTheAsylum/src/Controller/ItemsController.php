<?php

namespace App\Controller;

use App\Entity\Items;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/server/items', name: 'items_index')]
    public function index(): JsonResponse
    {
        // Obtener el repositorio de la entidad Items
        $repository = $this->entityManager->getRepository(Items::class);

        // Obtener todos los items
        $items = $repository->findAll();

        // Serializar los datos en formato JSON
        $data = [];
        foreach ($items as $item) {
            
            $imageData = $item->getImage();

            $data[] = [
                'id_item' => $item->getIdItem(),
                'name_item' => $item->getNameItem(),
                // Si la imagen es NULL, $imageData ya será NULL.
                'image' => $imageData,
                'punctuation' => $item->getPunctuation(),
            ];
        }

        // Devolver una respuesta JSON con los datos y el código de estado 200 (OK)
        return $this->json($data);
    }
}

