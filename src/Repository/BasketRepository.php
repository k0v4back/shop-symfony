<?php

namespace App\Repository;

use App\Entity\Basket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function findWithProduct($user)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.user', 'c')
            ->where('c.id = :user_id')
            ->setParameter('user_id', $user)
            ->andWhere('t.status != :status')
            ->setParameter('status', Basket::BOUGHT)
            ->getQuery()
            ->getResult();
    }

    public function findWithProductForUserOrders($user)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.user', 'c')
            ->where('c.id = :user_id')
            ->setParameter('user_id', $user)
            ->andWhere('t.status != :status')
            ->setParameter('status', Basket::NOT_BOUGHT)
            ->getQuery()
            ->getResult();
    }
}
