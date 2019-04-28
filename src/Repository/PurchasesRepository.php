<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Purchases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Purchases|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchases|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchases[]    findAll()
 * @method Purchases[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchasesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Purchases::class);
    }

    public function findWithProduct($user)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.user', 'c')
            ->where('c.id = :user_id')
            ->setParameter('user_id', $user)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Purchases[] Returns an array of Purchases objects
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
    public function findOneBySomeField($value): ?Purchases
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
