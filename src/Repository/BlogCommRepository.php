<?php

namespace App\Repository;

use App\Entity\BlogComm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogComm|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogComm|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogComm[]    findAll()
 * @method BlogComm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCommRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogComm::class);
    }

//    /**
//     * @return BlogComm[] Returns an array of BlogComm objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogComm
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
