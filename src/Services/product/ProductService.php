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

    public function createProduct($modification, $tag, $photo, $title, $description,$price)
    {
        $product = new Product();
        $product->addModification($modification);
        $product->addTag($tag);
        $product->addPhoto($photo);
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);

        $product->setCreatedAt(time());

        $em = $this->entityManager;
        $em->persist($product);
        $em->flush();

        return $product;
    }

    public function updateProduct(string $title, $description, float $price)
    {
        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteProduct(Product $product)
    {
        $em = $this->entityManager;
        $em->remove($product);
    }
}