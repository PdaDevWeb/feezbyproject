<?php

namespace App\Repository;

use App\Entity\Third;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Third|null find($id, $lockMode = null, $lockVersion = null)
 * @method Third|null findOneBy(array $criteria, array $orderBy = null)
 * @method Third[]    findAll()
 * @method Third[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThirdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Third::class);
    }

    // /**
    //  * @return Third[] Returns an array of Third objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Third
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
