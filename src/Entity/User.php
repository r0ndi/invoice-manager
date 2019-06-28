<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="logo_url", type="string")
     */
    private $logoUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Contractor")
     * @ORM\JoinColumn(name="id_default_contractor", referencedColumnName="id", nullable=false)
     */
    private $defaultContractor;

    /**
     * @ORM\Column(name="is_active", type="boolean", options={"default": 1})
     */
    private $isActive;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getLogoUrl(): string
    {
        return $this->logoUrl ?? '';
    }

    public function setLogoUrl(string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    public function getDefaultContractor(): ?Contractor
    {
        return $this->defaultContractor;
    }

    public function setDefaultContractor(Contractor $defaultContractor)
    {
        $this->defaultContractor = $defaultContractor;
    }

    public function getRoles(): array
    {
        $roles = array_merge($this->roles, ['ROLE_USER']);
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt() {}

    public function eraseCredentials() {}

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('firstname', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.firstname.length'
            ]),
            new NotBlank([
                'message' => 'form.firstname.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('lastname', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.lastname.length'
            ]),
            new NotBlank([
                'message' => 'form.lastname.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('email', [
            new Email(),
            new NotBlank([
                'message' => 'form.email.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('password', [
            new Length([
                'min' => 6,
                'minMessage' => 'form.password.length'
            ]),
            new NotBlank([
                'message' => 'form.password.notBlank',
            ]),
        ]);
    }
}
