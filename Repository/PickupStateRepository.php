<?php

namespace App\Repository;

use App\Entity\PickupState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PickupState|null find($id, $lockMode = null, $lockVersion = null)
 * @method PickupState|null findOneBy(array $criteria, array $orderBy = null)
 * @method PickupState[]    findAll()
 * @method PickupState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickupStateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PickupState::class);
    }

    // /**
    //  * @return PickupState[] Returns an array of PickupState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PickupState
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
