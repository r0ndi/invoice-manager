<?php

namespace App\Repository;

use App\Entity\Contractor;
use App\Entity\User;
use App\Util\ConfigReader;
use App\Util\ServiceLocator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User[]    findAll()
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, User::class, $serviceLocator);
    }

    public function createFromForm(FormInterface $form, UserPasswordEncoderInterface $passwordEncoder): ?User
    {
        $user = new User();
        $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
        $user->setFirstname($form->get('firstname')->getData());
        $user->setLastname($form->get('lastname')->getData());
        $user->setEmail($form->get('email')->getData());
        $user->setIsActive(true);
        $user->setLogoUrl('');

        if (!$this->persist($user)) {
            return null;
        }

        return $user;
    }

    public function editAccountInfoFromForm(FormInterface $form, User $user): ?User
    {
        $contractorRepository = $this->getEntityManager()->getRepository(Contractor::class);
        $seller = $contractorRepository->find((int)$form->get('seller')->getData());

        if (!($seller instanceof Contractor)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.user.error.seller')
            );

            return null;
        }

        $user->setFirstname($form->get('firstname')->getData());
        $user->setLastname($form->get('lastname')->getData());
        $user->setEmail($form->get('email')->getData());
        $user->setDefaultContractor($seller);

        if (!$this->merge($user)) {
            return null;
        }

        return $user;
    }

    public function resetPassword(FormInterface $form, User $user, UserPasswordEncoderInterface $passwordEncoder): ?User
    {
        $password = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
        if ($passwordEncoder->isPasswordValid($user, $password)) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('form.user.error.resetPassword')
            );

            return null;
        }

        $user->setPassword($password);
        if (!$this->merge($user)) {
            return null;
        }

        return $user;
    }

    public function uploadLogo(FormInterface $form, User $user): ?User
    {
        $configReader = new ConfigReader();
        $logoFile = $form['logo']->getData();
        $path = $configReader->get('logo.path');
        $absolutePath = $configReader->get('logo.path.absolute');
        $filename = "logo-{$user->getId()}.{$logoFile->guessExtension()}";

        try {
            $logoFile->move($absolutePath, $filename);
        } catch (FileException $exception) {
            $this->getServiceLocator()->getNotifyService()->addError($exception->getMessage());
            return null;
        }

        $user->setLogoUrl($path . $filename);
        if (!$this->merge($user)) {
            return null;
        }

        return $user;
    }
}
