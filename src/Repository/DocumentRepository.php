<?php

namespace App\Repository;

use App\Entity\DocumentPosition;
use App\Entity\Tax;
use App\Entity\Util;
use DateTime;
use App\Entity\Contractor;
use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\PaymentMethod;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function createFromForm(FormInterface $form, User $user): ?Document
    {
        $buyer = $this->getEntityManager()->find(Contractor::class, $form->get('buyer')->getData());
        $seller = $this->getEntityManager()->find(Contractor::class, $form->get('seller')->getData());
        $documentType = $this->getEntityManager()->find(DocumentType::class, $form->get('documentType')->getData());
        $paymentMethod = $this->getEntityManager()->find(PaymentMethod::class, $form->get('paymentMethod')->getData());
        $positionUtil = $this->getEntityManager()->find(Util::class, $form->get('positionUtil')->getData());
        $positionTax = $this->getEntityManager()->find(Tax::class, $form->get('positionTax')->getData());

        if (!($buyer instanceof Contractor)) {
            return null;
        }

        if (!($seller instanceof Contractor)) {
            return null;
        }

        if (!($documentType instanceof DocumentType)) {
            return null;
        }

        if (!($paymentMethod instanceof PaymentMethod)) {
            return null;
        }

        if (!($positionUtil instanceof Util)) {
            return null;
        }

        if (!($positionTax instanceof Tax)) {
            return null;
        }

        $document = new Document();
        $document->setUser($user);
        $document->setStatus(true);
        $document->setBuyer($buyer);
        $document->setSeller($seller);
        $document->setDateAdded(new DateTime());
        $document->setDocumentType($documentType);
        $document->setPaymentMethod($paymentMethod);
        $document->setTitle($form->get('title')->getData());
        $document->setBankNo($form->get('bankNo')->getData());
        $document->setPaid((bool)$form->get('paid')->getData());
        $document->setPlaceIssue($form->get('placeIssue')->getData());
        $document->setDateSell(new DateTime($form->get('dateSell')->getData()));
        $document->setDateIssue(new DateTime($form->get('dateIssue')->getData()));
        $document->setPaymentDateLimit(new DateTime($form->get('paymentDateLimit')->getData()));

        $this->getEntityManager()->persist($document);

        $documentPosition = new DocumentPosition();
        $documentPosition->setDocument($document);
        $documentPosition->setUtil($positionUtil);
        $documentPosition->setTax($positionTax);
        $documentPosition->setName($form->get('positionName')->getData());
        $documentPosition->setQuantity($form->get('positionQuantity')->getData());
        $documentPosition->setPrice($form->get('positionNetPrice')->getData());

        $this->getEntityManager()->persist($documentPosition);
        $this->getEntityManager()->flush();

        return $document;
    }

    public function editFromForm(FormInterface $form, Document $document, User $user): ?Document
    {
        $buyer = $this->getEntityManager()->find(Contractor::class, $form->get('buyer')->getData());
        $seller = $this->getEntityManager()->find(Contractor::class, $form->get('seller')->getData());
        $documentType = $this->getEntityManager()->find(DocumentType::class, $form->get('documentType')->getData());
        $paymentMethod = $this->getEntityManager()->find(PaymentMethod::class, $form->get('paymentMethod')->getData());
        $positionUtil = $this->getEntityManager()->find(Util::class, $form->get('positionUtil')->getData());
        $positionTax = $this->getEntityManager()->find(Tax::class, $form->get('positionTax')->getData());

        if (!($buyer instanceof Contractor)) {
            return null;
        }

        if (!($seller instanceof Contractor)) {
            return null;
        }

        if (!($documentType instanceof DocumentType)) {
            return null;
        }

        if (!($paymentMethod instanceof PaymentMethod)) {
            return null;
        }

        if (!($positionUtil instanceof Util)) {
            return null;
        }

        if (!($positionTax instanceof Tax)) {
            return null;
        }

        $document->setUser($user);
        $document->setStatus(true);
        $document->setBuyer($buyer);
        $document->setSeller($seller);
        $document->setDateAdded(new DateTime());
        $document->setDocumentType($documentType);
        $document->setPaymentMethod($paymentMethod);
        $document->setTitle($form->get('title')->getData());
        $document->setBankNo($form->get('bankNo')->getData());
        $document->setPaid((bool)$form->get('paid')->getData());
        $document->setPlaceIssue($form->get('placeIssue')->getData());
        $document->setDateSell(new DateTime($form->get('dateSell')->getData()));
        $document->setDateIssue(new DateTime($form->get('dateIssue')->getData()));
        $document->setPaymentDateLimit(new DateTime($form->get('paymentDateLimit')->getData()));

        $this->getEntityManager()->merge($document);

        $documentPosition = $document->getPositions()->first();
        $documentPosition->setDocument($document);
        $documentPosition->setUtil($positionUtil);
        $documentPosition->setTax($positionTax);
        $documentPosition->setName($form->get('positionName')->getData());
        $documentPosition->setQuantity($form->get('positionQuantity')->getData());
        $documentPosition->setPrice($form->get('positionNetPrice')->getData());

        $this->getEntityManager()->merge($documentPosition);
        $this->getEntityManager()->flush();

        return $document;
    }

    public function changeStatus(Document $document): Document
    {
        $document->setStatus(!$document->getStatus());

        $this->getEntityManager()->merge($document);
        $this->getEntityManager()->flush();

        return $document;
    }

    public function findAllInCurrentMonth(): array
    {
        $currentMonth = (new DateTime())->format('Y-m');

        return $this->createQueryBuilder('d')
            ->andWhere('d.dateAdded LIKE :dateAdded')
            ->andWhere('d.status = 1')
            ->setParameter('dateAdded', "%$currentMonth%")
            ->getQuery()
            ->getArrayResult();
    }
}
