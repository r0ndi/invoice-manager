<?php

namespace App\Repository;

use App\Entity\DocumentPosition;
use App\Entity\Tax;
use App\Entity\Util;
use App\Util\ServiceLocator;
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
class DocumentRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, Document::class, $serviceLocator);
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
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.buyer')
            );

            return null;
        }

        if (!($seller instanceof Contractor)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.seller')
            );

            return null;
        }

        if (!($documentType instanceof DocumentType)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.documentType')
            );

            return null;
        }

        if (!($paymentMethod instanceof PaymentMethod)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.paymentMethod')
            );

            return null;
        }

        if (!($positionUtil instanceof Util)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.util')
            );

            return null;
        }

        if (!($positionTax instanceof Tax)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.tax')
            );

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

        if (!$this->persist($document, false)) {
            return null;
        }

        $documentPosition = new DocumentPosition();
        $documentPosition->setDocument($document);
        $documentPosition->setUtil($positionUtil);
        $documentPosition->setTax($positionTax);
        $documentPosition->setName($form->get('positionName')->getData());
        $documentPosition->setQuantity($form->get('positionQuantity')->getData());
        $documentPosition->setPrice($form->get('positionNetPrice')->getData());
        $document->getPositions()->add($documentPosition);

        if (!$this->persist($documentPosition)) {
            return null;
        }

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
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.buyer')
            );

            return null;
        }

        if (!($seller instanceof Contractor)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.seller')
            );

            return null;
        }

        if (!($documentType instanceof DocumentType)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.documentType')
            );

            return null;
        }

        if (!($paymentMethod instanceof PaymentMethod)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.paymentMethod')
            );

            return null;
        }

        if (!($positionUtil instanceof Util)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.util')
            );

            return null;
        }

        if (!($positionTax instanceof Tax)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.document.error.tax')
            );

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

        if (!$this->merge($document, false)) {
            return null;
        }

        $documentPosition = $document->getPositions()->first();
        $documentPosition->setDocument($document);
        $documentPosition->setUtil($positionUtil);
        $documentPosition->setTax($positionTax);
        $documentPosition->setName($form->get('positionName')->getData());
        $documentPosition->setQuantity($form->get('positionQuantity')->getData());
        $documentPosition->setPrice($form->get('positionNetPrice')->getData());

        $document->getPositions()->clear();
        $document->getPositions()->add($documentPosition);

        if (!$this->merge($documentPosition)) {
            return null;
        }

        return $document;
    }

    public function changeStatus(Document $document): ?Document
    {
        $document->setStatus(!$document->getStatus());
        if (!$this->merge($document)) {
            return null;
        }

        return $document;
    }

    public function findAllInCurrentMonth(): array
    {
        $currentMonth = (new DateTime())->format('Y-m');

        return $this->createQueryBuilder('d')
            ->andWhere('d.dateAdded LIKE :dateAdded')
            ->andWhere('d.status = 1')
            ->setParameter('dateSell', "%$currentMonth%")
            ->getQuery()
            ->getArrayResult();
    }
}
