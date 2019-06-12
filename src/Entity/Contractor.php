<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Table(name="contractors")
 * @ORM\Entity(repositoryClass="App\Repository\ContractorRepository")
 */
class Contractor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="text")
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     */
    private $postcode;

    /**
     * @ORM\Column(type="text")
     */
    private $nip;

    /**
     * @ORM\Column(type="text")
     */
    private $regon;

    /**
     * @ORM\Column(name="bank_no", type="text")
     */
    private $bankNo;

    /**
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address ?? '';
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function getCity(): string
    {
        return $this->city ?? '';
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getPostcode(): string
    {
        return $this->postcode ?? '';
    }

    public function setPostcode(string $postcode)
    {
        $this->postcode = $postcode;
    }

    public function getNip(): string
    {
        return $this->nip ?? '';
    }

    public function setNip(string $nip)
    {
        $this->nip = $nip;
    }

    public function getRegon(): string
    {
        return $this->regon ?? '';
    }

    public function setRegon(string $regon)
    {
        $this->regon = $regon;
    }

    public function getBankNo(): string
    {
        return $this->bankNo ?? '';
    }

    public function setBankNo(string $bankNo)
    {
        $this->bankNo = $bankNo;
    }

    public function getDateAdded(string $dateFormat = 'Y-m-d H:i:s'): string
    {
        return $this->dateAdded->format($dateFormat);
    }

    public function setDateAdded(DateTime $dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status)
    {
        $this->status = $status;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('name', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.name.length'
            ]),
            new NotBlank([
                'message' => 'form.name.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('address', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.address.length'
            ]),
            new NotBlank([
                'message' => 'form.address.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('city', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.city.length'
            ]),
            new NotBlank([
                'message' => 'form.city.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('postcode', [
            new Length([
                'min' => 5,
                'minMessage' => 'form.postcode.length'
            ]),
            new NotBlank([
                'message' => 'form.postcode.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('nip', [
            new Length([
                'min' => 9,
                'minMessage' => 'form.nip.length'
            ]),
            new NotBlank([
                'message' => 'form.nip.notBlank',
            ]),
        ]);
    }
}
