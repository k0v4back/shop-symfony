<?php

namespace App\Services\product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPhoto(string $title, $description, float $price, int $created_at)
    {
        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setCreatedAt($created_at);

        $em = $this->entityManager;
        $em->persist($product);
        $em->flush();

        return $product;
    }

    public function updatePhoto(string $title, $description, float $price, int $created_at)
    {
        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setCreatedAt($created_at);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deletePhoto(Product $product)
    {
        $em = $this->entityManager;
        $em->remove($product);
    }
}