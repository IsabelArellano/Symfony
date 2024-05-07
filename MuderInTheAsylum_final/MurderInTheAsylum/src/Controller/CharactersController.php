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
          
            $imageData = $character->getImage();

            $data[] = [
                'id_character' => $character->getIdCharacter(),
                'name_character' => $character->getNameCharacter(),
                // Si la imagen es NULL, $imageData ya será NULL.
                'image' => $imageData,
                'description_character' => $character->getDescriptionCharacter(),
                'skills_character' => $character->getSkillsCharacter(),
            ];
        }

        // Devolver una respuesta JSON con los datos y el código de estado 200 (OK)
        return $this->json($data);
    }
}

?>


