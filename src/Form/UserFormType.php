<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Contractor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->getUser($builder);
        $contractorRepository = $this->getDoctrine($builder)->getRepository(Contractor::class);

        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'value' => $user->getFirstname(),
                    'placeholder' => 'form.user.firstname'
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'value' => $user->getLastname(),
                    'placeholder' => 'form.user.lastname'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'value' => $user->getEmail(),
                    'placeholder' => 'form.user.email'
                ]
            ])
            ->add('seller', ChoiceType::class, [
                'label' => 'form.user.label.seller',
                'choices' => $contractorRepository->getAllToForm() ?? [],
                'attr' => [
                    'value' => $user->getDefaultContractor() ? $user->getDefaultContractor()->getId() : null,
                    'class' => 'select-picker'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.user.submit'
            ])
        ;
    }

    private function getDoctrine(FormBuilderInterface $builder): ManagerRegistry
    {
        return $builder->getData()['doctrine'];
    }

    private function getUser(FormBuilderInterface $builder): User
    {
        return $builder->getData()['user'];
    }
}