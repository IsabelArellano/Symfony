<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="Message")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_message;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code_message;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $body_message;

    // Getters and setters for the properties
    public function getIdMessage()
    {
        return $this->id_message;
    }

    public function getCodeMessage()
    {
        return $this->code_message;
    }

    public function getBodyMessage()
    {
        return $this->body_message;
    }
}

