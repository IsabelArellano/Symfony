<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="user_character", columns={"id_character"}), @ORM\Index(name="user_password", columns={"id_password"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_user", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $nameUser = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $email = 'NULL';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_character", referencedColumnName="id_user")
     * })
     */
    private $idCharacter;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_password", referencedColumnName="id_user")
     * })
     */
    private $idPassword;


}
