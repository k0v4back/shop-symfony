<?php

namespace App\Services\product;

use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCategory(string $title, $categorySend = null)
    {
        $slugify = new Slugify();

//        var_dump($categorySend);die();

        $category = new Category();
        $category->setTitle($title);
        $category->setParent($categorySend);
        $category->setSlug($slugify->slugify($title));

        $em = $this->entityManager;
        $em->persist($category);
        $em->flush();
        return $category;
    }

    public function updateCategory(string $title, Category $categorySend)
    {
        $category = new Category();
        $category->setTitle($title);
        $category->setParent($categorySend);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteCategory(Category $categorySend)
    {
        $em = $this->entityManager;
        $em->remove($categorySend);
    }
}