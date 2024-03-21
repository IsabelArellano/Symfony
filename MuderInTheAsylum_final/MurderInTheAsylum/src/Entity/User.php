<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="id_type", columns={"id_type"}), @ORM\Index(name="id_password_hash", columns={"id_password_hash"})})
 * @ORM\Entity
 */
class User implements PasswordAuthenticatedUserInterface
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
     * @ORM\Column(name="name_user", type="string", length=45, nullable=true)
     */
    private $nameUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname_user", type="string", length=45, nullable=true)
     */
    private $surnameUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nickname_user", type="string", length=45, nullable=true)
     */
    private $nicknameUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="age_user", type="string", length=45, nullable=true)
     */
    private $ageUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_user", type="string", length=45, nullable=true)
     */
    private $emailUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="phone_user", type="integer", nullable=true)
     */
    private $phoneUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_user", type="blob", length=65535, nullable=true)
     */
    private $imageUser;

    /**
     * @var UserType|null
     *
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $idType;

    /**
     * @var PasswordHash|null
     *
     * @ORM\ManyToOne(targetEntity="PasswordHash")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_password_hash", referencedColumnName="id_password_hash")
     * })
     */
    private $idPasswordHash;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getNameUser(): ?string
    {
        return $this->nameUser;
    }

    public function setNameUser(?string $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getSurnameUser(): ?string
    {
        return $this->surnameUser;
    }

    public function setSurnameUser(?string $surnameUser): self
    {
        $this->surnameUser = $surnameUser;

        return $this;
    }

    public function getNicknameUsern(): ?string
    {
        return $this->nicknameUser;
    }

    public function setNicknameUser(?string $nicknameUsern): self
    {
        $this->nicknameUser = $nicknameUsern;

        return $this;
    }

    public function getAgeUser(): ?string
    {
        return $this->ageUser;
    }

    public function setAgeUser(?string $ageUser): self
    {
        $this->ageUser = $ageUser;

        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->emailUser;
    }

    public function setEmailUser(?string $emailUser): self
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    public function getPhoneUser(): ?int
    {
        return $this->phoneUser;
    }

    public function setPhoneUser(?int $phoneUser): self
    {
        $this->phoneUser = $phoneUser;

        return $this;
    }

    // public function getPassword(): ?string
    // {
    //     return $this->password;
    // }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getImageUser()
    {
        return $this->imageUser;
    }

    public function setImageUser($imageUser): self
    {
        $this->imageUser = $imageUser;

        return $this;
    }

    public function getIdType(): ?UserType
    {
        return $this->idType;
    }

    public function setIdType(?UserType $idType): self
    {
        $this->idType = $idType;

        return $this;
    }

    public function getIdPasswordHash(): ?PasswordHash
    {
        return $this->idPasswordHash;
    }

    public function setIdPasswordHash(?PasswordHash $idPasswordHash): self
    {
        $this->idPasswordHash = $idPasswordHash;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function getUsername(): string
    {
        return $this->nicknameUser;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
