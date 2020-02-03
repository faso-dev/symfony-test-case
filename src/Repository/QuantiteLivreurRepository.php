<?php

namespace App\Repository;

use App\Entity\QuantiteLivreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QuantiteLivreur|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuantiteLivreur|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuantiteLivreur[]    findAll()
 * @method QuantiteLivreur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuantiteLivreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuantiteLivreur::class);
    }

    // /**
    //  * @return QuantiteLivreur[] Returns an array of QuantiteLivreur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuantiteLivreur
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
