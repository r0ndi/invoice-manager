<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Document;
use App\Util\PriceCalculator;
use App\Entity\DocumentPosition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $priceCalculator = null;
        $user = $this->getUser($builder);
        $document = $this->getDocument($builder);
        $position = $this->getDocumentPosition($builder);

        if ($position->getId()) {
            $priceCalculator = new PriceCalculator($position->getPrice(), $position->getTax(), $position->getQuantity());
        }

        if ($user->getDefaultContractor() && !$document->getSeller()) {
            $document->setSeller($user->getDefaultContractor());
        }

        if ($user->getDefaultContractor() && !$document->getBankNo()) {
            $document->setBankNo($user->getDefaultContractor()->getBankNo());
        }

        $builder
            ->add('documentType', ChoiceType::class, [
                'label' => 'form.document.label.documentType',
                'choices' => $builder->getData()['documentTypes'] ?? [],
                'attr' => [
                    'value' => $document->getDocumentType() ? $document->getDocumentType()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'form.document.label.title',
                'attr' => [
                    'value' => $document->getTitle(),
                    'placeholder' => 'form.document.title'
                ]
            ])
            ->add('dateSell', TextType::class, [
                'label' => 'form.document.label.dateSell',
                'attr' => [
                    'value' => $document->getDateSell()->format('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('dateIssue', TextType::class, [
                'label' => 'form.document.label.dateIssue',
                'attr' => [
                    'value' => $document->getDateIssue()->format('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('placeIssue', TextType::class, [
                'label' => 'form.document.label.placeIssue',
                'attr' => [
                    'value' => $document->getPlaceIssue(),
                    'placeholder' => 'form.document.placeIssue'
                ]
            ])
            ->add('seller', ChoiceType::class, [
                'label' => 'form.document.label.seller',
                'choices' => $builder->getData()['contractors'] ?? [],
                'attr' => [
                    'value' => $document->getSeller() ? $document->getSeller()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('buyer', ChoiceType::class, [
                'label' => 'form.document.label.buyer',
                'choices' => $builder->getData()['contractors'] ?? [],
                'attr' => [
                    'value' => $document->getBuyer() ? $document->getBuyer()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionName', TextType::class, [
                'label' => 'form.document.label.positionName',
                'attr' => [
                    'value' => $position->getName(),
                    'placeholder' => 'form.document.positionName'
                ]
            ])
            ->add('positionUtil', ChoiceType::class, [
                'label' => 'form.document.label.positionUtil',
                'choices' => $builder->getData()['utils'] ?? [],
                'attr' => [
                    'value' => $position->getUtil() ? $position->getUtil()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionQuantity', NumberType::class, [
                'label' => 'form.document.label.positionQuantity',
                'attr' => [
                    'value' => $position->getQuantity() ?? 1,
                    'placeholder' => 'form.document.positionQuantity'
                ]
            ])
            ->add('positionNetPrice', NumberType::class, [
                'label' => 'form.document.label.positionNetPrice',
                'attr' => [
                    'value' => $priceCalculator ? $priceCalculator->getNet() : null,
                    'placeholder' => 'form.document.positionNetPrice'
                ]
            ])
            ->add('positionNetValue', NumberType::class, [
                'label' => 'form.document.label.positionNetValue',
                'attr' => [
                    'value' => $priceCalculator ? $priceCalculator->getNetValue() : null,
                    'placeholder' => 'form.document.positionNetValue',
                    'readonly' => true
                ]
            ])
            ->add('positionTax', ChoiceType::class, [
                'label' => 'form.document.label.positionTax',
                'choices' => $builder->getData()['taxes'] ?? [],
                'attr' => [
                    'value' => $position->getTax() ? $position->getTax()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionGrossPrice', NumberType::class, [
                'label' => 'form.document.label.positionGrossPrice',
                'attr' => [
                    'value' => $priceCalculator ? $priceCalculator->getGross() : null,
                    'placeholder' => 'form.document.positionGrossPrice',
                    'readonly' => true
                ]
            ])
            ->add('positionGrossValue', NumberType::class, [
                'label' => 'form.document.label.positionGrossValue',
                'attr' => [
                    'value' => $priceCalculator ? $priceCalculator->getGrossValue() : null,
                    'placeholder' => 'form.document.positionGrossValue',
                    'readonly' => true
                ]
            ])
            ->add('paymentMethod', ChoiceType::class, [
                'label' => 'form.document.label.paymentMethod',
                'choices' => $builder->getData()['paymentMethods'] ?? [],
                'attr' => [
                    'value' => $document->getPaymentMethod() ? $document->getPaymentMethod()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('paymentDateLimit', TextType::class, [
                'label' => 'form.document.label.paymentDateLimit',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'value' => $document->getPaymentDateLimit()->format('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('paid', ChoiceType::class, [
                'label' => 'form.document.label.paid',
                'choices' => ['niezapłacono' => 0, 'zapłacono' => 1],
                'attr' => [
                    'value' => $document->getPaid(),
                    'class' => 'select-picker'
                ]
            ])
            ->add('bankNo', TextType::class, [
                'label' => 'form.document.label.bankNo',
                'attr' => [
                    'value' => $document->getBankNo(),
                    'placeholder' => 'form.document.bankNo'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.document.submit'
            ]);
    }

    private function getDocument(FormBuilderInterface $builder): Document
    {
        return $builder->getData()['document'];
    }

    private function getUser(FormBuilderInterface $builder): User
    {
        return $builder->getData()['user'];
    }

    private function getDocumentPosition(FormBuilderInterface $builder): DocumentPosition
    {
        $document = $this->getDocument($builder);

        if ($document->getPositions()->count() <= 0) {
            return new DocumentPosition();
        }

        return $document->getPositions()->first();
    }
}