<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
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
     * @var int|null
     *
     * @ORM\Column(name="age_user", type="integer", nullable=true)
     */
    private $ageUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_user", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $emailUser = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="phone_user", type="integer", nullable=true)
     */
    private $phoneUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * @var resource|null
     *
     * @ORM\Column(name="image_user", type="blob", nullable=true)
     */
    private $imageUser;
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

    public function getNicknameUser(): ?string
    {
        return $this->nicknameUser;
    }

    public function setNicknameUser(?string $nicknameUser): self
    {
        $this->nicknameUser = $nicknameUser;

        return $this;
    }

    public function getAgeUser(): ?int
    {
        return $this->ageUser;
    }

    public function setAgeUser(?int $ageUser): self
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

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
}
