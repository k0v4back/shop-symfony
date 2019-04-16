<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Photo::class);
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

    public function findOneBySort($sort, $id)
    {
        return $this->createQueryBuilder('t')
            ->andwhere('t.sort = :sort')
            ->setParameter('sort', $sort)
            ->andwhere('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
