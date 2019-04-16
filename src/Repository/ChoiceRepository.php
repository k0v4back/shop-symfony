<?php

namespace App\Repository;

use App\Entity\Choice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Choice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Choice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Choice[]    findAll()
 * @method Choice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Choice::class);
    }

    public function findMaxSort($product)
    {
        return $this->createQueryBuilder('t')
            ->select('t.sort')
            ->innerJoin('t.product', 'c')
            ->where('c.id = :product_id')
            ->setParameter('product_id', $product)
            ->orderBy('t.sort', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function findMinSort($product)
    {
        return $this->createQueryBuilder('t')
            ->select('t.sort')
            ->innerJoin('t.product', 'c')
            ->where('c.id = :product_id')
            ->setParameter('product_id', $product)
            ->orderBy('t.sort', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function findAllSort($product)
    {
        return $this->createQueryBuilder('t')
            ->select('t.sort')
            ->innerJoin('t.product', 'c')
            ->where('c.id = :product_id')
            ->setParameter('product_id', $product)
            ->orderBy('t.sort', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
