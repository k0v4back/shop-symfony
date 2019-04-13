<?php

namespace App\Services\product;

use App\Entity\Modification;
use App\Entity\Tag;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    private $productRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    public function createTag(int $tagId, $productId = null)
    {
        if (!$productId) {
            $tag = new Tag();
            $tag->setTagId($tagId);

            $em = $this->entityManager;
            $em->persist($tag);
            $em->flush();

            return $tag;
        }

        $product = $this->productRepository->find($productId);
        $tag = new Tag();
        $tag->setTagId($tagId);
        $tag->setProduct($product);

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;

    }

    public function updateTag(int $tagId)
    {
        $tag = new Tag();
        $tag->setTagId($tagId);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(Tag $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
        $em->flush();
    }
}