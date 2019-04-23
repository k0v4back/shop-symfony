<?php

namespace App\Services\basket;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class BasketService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCategory($quantity, $pricePerItem, User $user, Product $product)
    {
        $basket = new Basket();
        $basket->setQuantity($quantity);
        $basket->setPricePerItem($pricePerItem);
        $basket->setUser($user);
        $basket->setProduct($product);

        $em = $this->entityManager;
        $em->persist($basket);
        $em->flush();
        return $basket;
    }

    public function updateCategory($quantity, $pricePerItem, User $user, Product $product)
    {
        $basket = new Basket();
        $basket->setQuantity($quantity);
        $basket->setPricePerItem($pricePerItem);
        $basket->setUser($user);
        $basket->setProduct($product);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteCategory(Basket $basket)
    {
        $em = $this->entityManager;
        $em->remove($basket);
    }
}