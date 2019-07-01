<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'form.user.password'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.user.submit'
            ])
        ;
    }
}