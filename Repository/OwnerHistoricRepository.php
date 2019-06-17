<?php

namespace App\Repository;

use App\Entity\OwnerHistoric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OwnerHistoric|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnerHistoric|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnerHistoric[]    findAll()
 * @method OwnerHistoric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerHistoricRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OwnerHistoric::class);
    }

    // /**
    //  * @return OwnerHistoric[] Returns an array of OwnerHistoric objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnerHistoric
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
