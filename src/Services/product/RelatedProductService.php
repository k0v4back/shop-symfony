<?php

namespace App\Services\product;

use App\Entity\RelatedProducts;
use Doctrine\ORM\EntityManagerInterface;

class RelatedProductService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPhoto(string $title, int $product_id)
    {
        $relatedProduct = new RelatedProducts();
        $relatedProduct->setProductId($title);
        $relatedProduct->setRelatedProductId($product_id);

        $em = $this->entityManager;
        $em->persist($relatedProduct);
        $em->flush();

        return $relatedProduct;
    }

    public function updatePhoto(string $title, int $product_id)
    {
        $relatedProduct = new RelatedProducts();
        $relatedProduct->setProductId($title);
        $relatedProduct->setRelatedProductId($product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deletePhoto(RelatedProducts $relatedProducts)
    {
        $em = $this->entityManager;
        $em->remove($relatedProducts);
    }
}