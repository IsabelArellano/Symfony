<?php

namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Characters
*
* @ORM\Table(name="characters")
* @ORM\Entity
*/
class Characters
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_character", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCharacter;
 
    /**
     * @var string|null
     *
     * @ORM\Column(name="name_character", type="string", length=50, nullable=true)
     */
    private $nameCharacter;
 
    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="blob", nullable=true)
     */
    private $image;
 
    /**
     * @var string|null
     *
     * @ORM\Column(name="description_character", type="string", length=500, nullable=true)
     */
    private $descriptionCharacter;
 
    /**
     * @var string|null
     *
     * @ORM\Column(name="skills_character", type="string", length=200, nullable=false)
     */
    private $skillsCharacter;
 
    // Getters y setters
 
    public function getIdCharacter(): ?int
    {
        return $this->idCharacter;
    }
 
    public function getNameCharacter(): ?string
    {
        return $this->nameCharacter;
    }
 
    public function setNameCharacter(?string $nameCharacter): self
    {
        $this->nameCharacter = $nameCharacter;
 
        return $this;
    }
 
    public function getImage(): ?string
    {
        // Si la imagen es NULL, retornamos NULL
        if ($this->image === null) {
            return null;
        }
 
        // Verificamos si la imagen es una cadena base64
        if (is_string($this->image) && strpos($this->image, 'data:image') === 0) {
            // Si es una cadena base64, ya está en el formato correcto
            return $this->image;
        } else {
            // Si no es una cadena base64, devolvemos la imagen en formato base64
            return base64_encode(stream_get_contents($this->image));
        }
    }
 
    public function setImage(?string $image): self
    {
        $this->image = $image;
 
        return $this;
    }
 
    public function getDescriptionCharacter(): ?string
    {
        return $this->descriptionCharacter;
    }
 
    public function setDescriptionCharacter(?string $descriptionCharacter): self
    {
        $this->descriptionCharacter = $descriptionCharacter;
 
        return $this;
    }
 
    public function getSkillsCharacter(): ?string
    {
        return $this->skillsCharacter;
    }
 
    public function setSkillsCharacter(?string $skillsCharacter): self
    {
        $this->skillsCharacter = $skillsCharacter;
 
        return $this;
    }
}