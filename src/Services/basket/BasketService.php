<?php

namespace App\Services\basket;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;

class BasketService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var BasketRepository */
    private $basketRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BasketRepository $basketRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->basketRepository = $basketRepository;
    }

    public function createBasket($quantity, $pricePerItem, User $user, Product $product)
    {
        $check = $this->basketRepository->findOneBy(['product' => $product, 'user' => $user]);
        if (!isset($check)) {
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
        $basket = new Basket();
        return $basket;
    }

    public function updateBasket($quantity, $pricePerItem, User $user, Product $product)
    {
        $basket = new Basket();
        $basket->setQuantity($quantity);
        $basket->setPricePerItem($pricePerItem);
        $basket->setUser($user);
        $basket->setProduct($product);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteBasket(Basket $basket)
    {
        $em = $this->entityManager;
        $em->remove($basket);
    }
}