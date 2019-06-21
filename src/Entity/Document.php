<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="DocumentType", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_document_type", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $documentType;

    /**
     * @ORM\ManyToOne(targetEntity="Contractor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_seller", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity="Contractor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_seller", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $buyer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="date_sell", type="datetime")
     */
    private $dateSell;

    /**
     * @ORM\Column(name="date_issue", type="datetime")
     */
    private $dateIssue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeIssue;
    /**
     * @ORM\Column(name="bank_no", type="string", length=255)
     */
    private $bankNo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_payment_method", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $paymentMethod;

    /**
     * @ORM\Column(name="payment_date_limit", type="datetime")
     */
    private $paymentDateLimit;

    /**
     * @ORM\OneToMany(targetEntity="DocumentPosition", mappedBy="document")
     */
    private $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getDocumentType(): ?DocumentType
    {
        return $this->documentType;
    }

    public function setDocumentType(DocumentType $documentType): void
    {
        $this->documentType = $documentType;
    }

    public function getSeller(): ?Contractor
    {
        return $this->seller;
    }

    public function setSeller(Contractor $seller): void
    {
        $this->seller = $seller;
    }

    public function getBuyer(): ?Contractor
    {
        return $this->buyer;
    }

    public function setBuyer(Contractor $buyer): void
    {
        $this->buyer = $buyer;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDateSell(): DateTime
    {
        return $this->dateSell ? $this->dateSell : new DateTime();
    }

    public function setDateSell(DateTime $dateSell): void
    {
        $this->dateSell = $dateSell;
    }

    public function getDateIssue(): DateTime
    {
        return $this->dateIssue ? $this->dateIssue : new DateTime();
    }

    public function setDateIssue(DateTime $dateIssue): void
    {
        $this->dateIssue = $dateIssue;
    }

    public function getPlaceIssue(): string
    {
        return $this->placeIssue ?? '';
    }

    public function setPlaceIssue(string $placeIssue): void
    {
        $this->placeIssue = $placeIssue;
    }

    public function getPaid(): bool
    {
        return $this->paid ?? false;
    }

    public function setPaid(bool $paid): void
    {
        $this->paid = $paid;
    }

    public function getBankNo(): string
    {
        return $this->bankNo;
    }

    public function setBankNo(string $bankNo)
    {
        $this->bankNo = $bankNo;
    }

    public function getDateAdded(): DateTime
    {
        return $this->dateAdded ? $this->dateAdded : new DateTime();
    }

    public function setDateAdded(DateTime $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getPaymentDateLimit(): DateTime
    {
        return $this->paymentDateLimit ? $this->paymentDateLimit : new DateTime();
    }

    public function setPaymentDateLimit(DateTime $paymentDateLimit): void
    {
        $this->paymentDateLimit = $paymentDateLimit;
    }

    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('title', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.title.length'
            ]),
            new NotBlank([
                'message' => 'form.title.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('dateSell', [
            new NotBlank([
                'message' => 'form.dateSell.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('dateIssue', [
            new NotBlank([
                'message' => 'form.dateIssue.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('placeIssue', [
            new Length([
                'min' => 3,
                'minMessage' => 'form.placeIssue.length'
            ]),
            new NotBlank([
                'message' => 'form.placeIssue.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('seller', [
            new NotBlank([
                'message' => 'form.seller.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('buyer', [
            new NotBlank([
                'message' => 'form.buyer.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('documentType', [
            new NotBlank([
                'message' => 'form.documentType.notBlank',
            ]),
        ]);

        $metadata->addPropertyConstraints('paymentMethod', [
            new NotBlank([
                'message' => 'form.paymentMethod.notBlank',
            ]),
        ]);

    }

}
