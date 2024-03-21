<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="items")
 * @ORM\Entity
 */
class Items
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_item", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idItem;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_item", type="string", length=50, nullable=true, options={"default"="'NULL'"})
     */
    private $nameItem = '\'NULL\'';

    /**
     * @var int|null
     *
     * @ORM\Column(name="punctuation", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $punctuation = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="blob", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $image = 'NULL';

    // Getters y setters

    public function getIdItem(): ?int
    {
        return $this->idItem;
    }

    public function getNameItem(): ?string
    {
        return $this->nameItem;
    }

    public function setNameItem(?string $nameItem): self
    {
        $this->nameItem = $nameItem;

        return $this;
    }

    public function getPunctuation(): ?int
    {
        return $this->punctuation;
    }

    public function setPunctuation(?int $punctuation): self
    {
        $this->punctuation = $punctuation;

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
}
