<?php

namespace App\Services\product;

use App\Entity\Product;
use App\Repository\StandartCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var StandartCategoryRepository */
    private $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        StandartCategoryRepository $categoryRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    public function createProduct($modification, $tag, $photo, $choice, $title, $description,$price)
    {
        $product = new Product();
        $product->addModification($modification);
        $product->addTag($tag);
        $product->addPhoto($photo);
        $product->addChoice($choice);
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);

        $product->setCreatedAt(time());

        $em = $this->entityManager;
        $em->persist($product);
        $em->flush();

        return $product;
    }

    public function updateProduct(string $title, $description, $price)
    {
        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);

        $em = $this->entityManager;
        $em->flush();

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        $em = $this->entityManager;
        $em->remove($product);
        $em->flush();
    }

    public function addCategory($categoryId, Product $product)
    {
        $category = $this->categoryRepository->find($categoryId);
        if (isset($category)) {
            $product->setCategory($category);

            $em = $this->entityManager;
            $em->persist($product);
            $em->flush();
        }
        return $category;
    }
}