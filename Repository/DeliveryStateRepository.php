<?php

namespace App\Repository;

use App\Entity\DeliveryState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeliveryState|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryState|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryState[]    findAll()
 * @method DeliveryState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryStateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeliveryState::class);
    }

    // /**
    //  * @return DeliveryState[] Returns an array of DeliveryState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliveryState
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
