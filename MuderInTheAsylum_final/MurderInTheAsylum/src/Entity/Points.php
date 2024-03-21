<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;


}
