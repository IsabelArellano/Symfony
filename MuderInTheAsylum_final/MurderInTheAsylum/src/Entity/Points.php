<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * Points
 *
 * @ORM\Table(name="points", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Points
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_point", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoint;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $points = NULL;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    // Getters and Setters

    /**
     * Get the value of idPoint
     *
     * @return int
     */
    public function getIdPoint(): int
    {
        return $this->idPoint;
    }

    /**
     * Get the value of points
     *
     * @return int|null
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * Set the value of points
     *
     * @param int|null $points
     * @return self
     */
    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get the value of idUser
     *
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @param User $idUser
     * @return self
     */
    public function setIdUser(User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
}
