<?php

namespace App\Repository;

use App\Entity\User;
use App\Util\ServiceLocator;
use DateTime;
use App\Entity\Contractor;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method Contractor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contractor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contractor[]    findAll()
 * @method Contractor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractorRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, Contractor::class, $serviceLocator);
    }

    public function changeStatus(Contractor $contractor): ?Contractor
    {
        $contractor->setStatus(!$contractor->getStatus());
        if (!$this->persist($contractor)) {
            return null;
        }

        return $contractor;
    }

    public function createFromForm(FormInterface $form, User $user): ?Contractor
    {
        $contractor = new Contractor();
        $contractor->setName($form->get('name')->getData());
        $contractor->setAddress($form->get('address')->getData());
        $contractor->setCity($form->get('city')->getData());
        $contractor->setPostcode($form->get('postcode')->getData());
        $contractor->setNip($form->get('nip')->getData());
        $contractor->setRegon($form->get('regon')->getData());
        $contractor->setBankNo($form->get('bankNo')->getData());
        $contractor->setDateAdded(new DateTime());
        $contractor->setStatus(true);
        $contractor->setUser($user);

        if (!$this->persist($contractor)) {
            return null;
        }

        return $contractor;
    }

    public function editFromForm(FormInterface $form, Contractor $contractor, User $user): ?Contractor
    {
        $contractor->setName($form->get('name')->getData());
        $contractor->setAddress($form->get('address')->getData());
        $contractor->setCity($form->get('city')->getData());
        $contractor->setPostcode($form->get('postcode')->getData());
        $contractor->setNip($form->get('nip')->getData());
        $contractor->setRegon($form->get('regon')->getData());
        $contractor->setBankNo($form->get('bankNo')->getData());
        $contractor->setDateAdded(new DateTime());
        $contractor->setStatus(true);
        $contractor->setUser($user);

        if (!$this->merge($contractor)) {
            return null;
        }

        return $contractor;
    }

    public function getAllToForm(): array
    {
        return array_map(function (Contractor $object) {
            return [$object->getName() => $object->getId()];
        }, $this->findBy(['status' => true]));
    }
}
