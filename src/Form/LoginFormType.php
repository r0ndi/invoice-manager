<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'form.login.email'], 'data' => $options['data']['lastUsername'] ?? ''])
            ->add('password', PasswordType::class, ['attr' => ['placeholder' => 'form.login.password']])
            ->add('login', SubmitType::class, ['label' => 'form.login.submit'])
        ;
    }
}