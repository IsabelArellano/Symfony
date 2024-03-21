<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * UserType
 *
 * @ORM\Table(name="user_type")
 * @ORM\Entity
 */
class UserType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_of_user", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $typeOfUser = 'NULL';


}
