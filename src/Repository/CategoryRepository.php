<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends NestedTreeRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findCategoryByTitle($title)
    {
        return $this->createQueryBuilder('t')
            ->where('t.title LIKE :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getResult();
    }

    public function getAllTitleOfCategory()
    {
        return $this->createQueryBuilder('p')
            ->select('title')
            ->getQuery();
    }

    public function getParentId($child_node_id)
    {
        // get parent_id of a tree element
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Category', 'c')
            ->where('c.id = :nodeId')
            ->setParameter('nodeId', $child_node_id)
            ->setMaxResults(1)
            ->getQuery();

        $parent = $query->getResult();
        $parent_null = $parent[0]->getParent();

        // if parent element is null - efectively element is root of the tree
        if ($parent_null === null)
        {
            $parent_id = $parent[0]->getId();
        }
        // if parent element is not root of the tree
        else
        {
            $parent_id = $parent[0]->getParent()->getId();
        }

        return $parent_id;
    }
}
