<?php



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
     * @ORM\Column(name="name_character", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $nameCharacter = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_character", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $descriptionCharacter = 'NULL';


}
