<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="document_positions")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentPositionRepository")
 */
class DocumentPosition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_document", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $document;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Util", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_util", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $util;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Tax", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_tax", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $tax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUtil(): ?Util
    {
        return $this->util;
    }

    public function setUtil(Util $util): void
    {
        $this->util = $util;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(Tax $tax): void
    {
        $this->tax = $tax;
    }
}
