<?php

namespace App\Services\product;

use App\Entity\RelatedProducts;
use Doctrine\ORM\EntityManagerInterface;

class RelatedService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createProduct(int $product_id, $related_product_id)
    {
        $relatedProduct = new RelatedProducts();
        $relatedProduct->setProductId($product_id);
        $relatedProduct->setRelatedProductId($related_product_id);

        $em = $this->entityManager;
        $em->persist($relatedProduct);
        $em->flush();

        return $relatedProduct;
    }

    public function updateProduct(int $product_id, $related_product_id)
    {
        $relatedProduct = new RelatedProducts();
        $relatedProduct->setProductId($product_id);
        $relatedProduct->setRelatedProductId($related_product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteProduct(RelatedProducts $relatedProducts)
    {
        $em = $this->entityManager;
        $em->remove($relatedProducts);
    }
}