<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LogoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logo', FileType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'form.user.logo'
                ], 'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                           "image/png",
                           "image/jpeg",
                           "image/jpg",
                        ],
                        'maxSizeMessage' => 'form.user.edit.logo.maxSize',
                        'mimeTypesMessage' => 'form.user.edit.logo.mimeTypes',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.user.submit'
            ])
        ;
    }
}