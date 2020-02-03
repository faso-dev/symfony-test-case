<?php

namespace App\Repository;

use App\Entity\MenuDuJour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MenuDuJour|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuDuJour|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuDuJour[]    findAll()
 * @method MenuDuJour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuDuJourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuDuJour::class);
    }

    // /**
    //  * @return MenuDuJour[] Returns an array of MenuDuJour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuDuJour
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
