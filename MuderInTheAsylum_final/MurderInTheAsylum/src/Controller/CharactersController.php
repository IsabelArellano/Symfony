<?php

namespace App\Controller;

use App\Entity\Characters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{
    private $entityManager;
 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
 
    #[Route('server/characters', name: 'characters_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // Obtener el repositorio de la entidad Characters
        $repository = $this->entityManager->getRepository(Characters::class);
 
        // Obtener todos los personajes
        $characters = $repository->findAll();
 
        // Serializar los datos en formato JSON
        $data = [];
        foreach ($characters as $character) {
            // Obtener los datos de la imagen como un blob
            $imageData = $this->getImageBlob($character->getImage());
 
            $data[] = [
                'id_character' => $character->getIdCharacter(),
                'name_character' => $character->getNameCharacter(),
                'image' => $imageData,
                'description_character' => $character->getDescriptionCharacter(),
                'skills_character' => $character->getSkillsCharacter(),
            ];
        }
 
        // Devolver una respuesta JSON con los datos y el código de estado 200 (OK)
        return $this->json($data);
    }
 
    // Método para convertir los datos de la imagen en un blob
    private function getImageBlob($imageData): ?string
    {
        if ($imageData === null) {
            return null;
        }
 
        // Si la imagen ya es un blob, devolverla directamente
        if (is_string($imageData)) {
            return $imageData;
        }
 
        // Si la imagen es un archivo, leerlo y convertirlo en un blob
        if (is_resource($imageData)) {
            $blobData = stream_get_contents($imageData);
            return base64_encode($blobData);
        }
 
        // Si la imagen es un objeto, convertirlo en un blob
        if (is_object($imageData) && method_exists($imageData, 'getBytes')) {
            return base64_encode($imageData->getBytes());
        }
 
        return null;
    }
}

?>


