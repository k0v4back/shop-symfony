<?php

namespace App\Services\product;

use App\Entity\Discount;
use App\Entity\Product;
use App\Repository\DiscountRepository;
use Doctrine\ORM\EntityManagerInterface;

class DiscountService
{
    /** @var DiscountRepository  */
    private $discountRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        DiscountRepository $discountRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->discountRepository = $discountRepository;
        $this->entityManager = $entityManager;
    }

   public function createDiscount(Product $product, int $percent) : bool
   {
       if(isset($product))
       {
            $discount = new Discount();
            $discount->setDate(time());
            $discount->setPercent($percent);
            $discount->setProduct($product);
       } else {
           throw new \ErrorException("Product is not exits");
       }

       $em = $this->entityManager;
       $em->persist($discount);
       $em->flush();

       return true;
   }

   public function updateDiscount(Discount $discount, int $percent, int $date)
   {
        if(isset($discount))
        {
            $discount->setDate($date);
            $discount->setPercent($percent);
            $em = $this->entityManager;
            $em->flush();
        } else {
            throw new \ErrorException("Product is not exits");
        }
   }

   public function deleteDiscount(Discount $discount)
   {
       if(isset($discount))
       {
           $em = $this->entityManager;
           $em->remove($discount);
           $em->flush();
       } else {
           throw new \ErrorException("Product is not exits");
       }
   }
}