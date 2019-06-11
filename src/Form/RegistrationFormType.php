<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'form.register.email']])
            ->add('password', PasswordType::class, ['attr' => ['placeholder' => 'form.register.password']])
            ->add('firstname', TextType::class, ['attr' => ['placeholder' => 'form.register.firstname']])
            ->add('lastname', TextType::class, ['attr' => ['placeholder' => 'form.register.lastname']])
            ->add('register', SubmitType::class, ['label' => 'form.register.submit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}