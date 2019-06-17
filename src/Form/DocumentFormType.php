<?php

namespace App\Form;

use Svg\Tag\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentType', ChoiceType::class, [
                'label' => 'form.document.label.documentType',
                'choices' => $options['data']['documentTypes'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'form.document.label.title',
                'attr' => [
                    'placeholder' => 'form.document.title'
                ]
            ])
            ->add('dateSell', TextType::class, [
                'label' => 'form.document.label.dateSell',
                'attr' => [
                    'value' => date('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('dateIssue', TextType::class, [
                'label' => 'form.document.label.dateIssue',
                'attr' => [
                    'value' => date('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('placeIssue', TextType::class, [
                'label' => 'form.document.label.placeIssue',
                'attr' => [
                    'placeholder' => 'form.document.placeIssue'
                ]
            ])
            ->add('seller', ChoiceType::class, [
                'label' => 'form.document.label.seller',
                'choices' => $options['data']['contractors'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('buyer', ChoiceType::class, [
                'label' => 'form.document.label.buyer',
                'choices' => $options['data']['contractors'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionName', TextType::class, [
                'label' => 'form.document.label.positionName',
                'attr' => [
                    'placeholder' => 'form.document.positionName'
                ]
            ])
            ->add('positionUtil', ChoiceType::class, [
                'label' => 'form.document.label.positionUtil',
                'choices' => $options['data']['utils'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionQuantity', NumberType::class, [
                'label' => 'form.document.label.positionQuantity',
                'attr' => [
                    'value' => 1,
                    'placeholder' => 'form.document.positionQuantity'
                ]
            ])
            ->add('positionNetPrice', NumberType::class, [
                'label' => 'form.document.label.positionNetPrice',
                'attr' => [
                    'placeholder' => 'form.document.positionNetPrice'
                ]
            ])
            ->add('positionNetValue', NumberType::class, [
                'label' => 'form.document.label.positionNetValue',
                'attr' => [
                    'placeholder' => 'form.document.positionNetValue'
                ]
            ])
            ->add('positionTax', ChoiceType::class, [
                'label' => 'form.document.label.positionTax',
                'choices' => $options['data']['taxes'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('positionGrossPrice', NumberType::class, [
                'label' => 'form.document.label.positionGrossPrice',
                'attr' => [
                    'placeholder' => 'form.document.positionGrossPrice'
                ]
            ])
            ->add('positionGrossValue', NumberType::class, [
                'label' => 'form.document.label.positionGrossValue',
                'attr' => [
                    'placeholder' => 'form.document.positionGrossValue'
                ]
            ])
            ->add('paymentMethod', ChoiceType::class, [
                'label' => 'form.document.label.paymentMethod',
                'choices' => $options['data']['paymentMethods'] ?? [],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('paymentDateLimit', TextType::class, [
                'label' => 'form.document.label.paymentDateLimit',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'value' => date('Y-m-d'),
                    'class' => 'date-picker'
                ]
            ])
            ->add('paid', ChoiceType::class, [
                'label' => 'form.document.label.paid',
                'choices' => ['unpaid' => 0, 'paid' => 1],
                'attr' => [
                    'class' => 'select-picker'
                ]
            ])
            ->add('bankNo', TextType::class, [
                'label' => 'form.document.label.bankNo',
                'attr' => [
                    'placeholder' => 'form.document.bankNo'
                ]
            ])
            ->add('create', SubmitType::class, [
                'label' => 'form.document.submit'
            ]);
    }
}