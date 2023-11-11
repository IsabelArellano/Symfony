<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Passwords
 *
 * @ORM\Table(name="passwords")
 * @ORM\Entity
 */
class Passwords
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_password", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPassword;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password_hash", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $passwordHash = 'NULL';


}
