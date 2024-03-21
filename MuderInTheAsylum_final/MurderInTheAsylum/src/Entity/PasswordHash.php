<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PasswordHash
 *
 * @ORM\Table(name="password_hash")
 * @ORM\Entity
 */
class PasswordHash
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_password_hash", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPasswordHash;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password_hashed", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $passwordHashed = 'NULL';


}
