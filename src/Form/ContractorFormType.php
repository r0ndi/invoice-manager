<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContractorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'form.contractor.name']])
            ->add('address', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'form.contractor.address']])
            ->add('city', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'form.contractor.city']])
            ->add('postcode', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'form.contractor.postcode']])
            ->add('nip', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'form.contractor.nip']])
            ->add('regon', TextType::class, ['label' => false, 'empty_data' => '', 'required' => false, 'attr' => ['placeholder' => 'form.contractor.regon']])
            ->add('bankNo', TextType::class, ['label' => false, 'empty_data' => '', 'required' => false, 'attr' => ['placeholder' => 'form.contractor.bankNo']])
            ->add('create', SubmitType::class, ['label' => 'form.contractor.submit'])
        ;
    }
}