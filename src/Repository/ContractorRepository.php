<?php

namespace App\Repository;

use App\Entity\User;
use DateTime;
use App\Entity\Contractor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method Contractor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contractor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contractor[]    findAll()
 * @method Contractor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contractor::class);
    }

    public function createFromForm(FormInterface $form, User $user): Contractor
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

        $this->getEntityManager()->persist($contractor);
        $this->getEntityManager()->flush();

        return $contractor;
    }
}
