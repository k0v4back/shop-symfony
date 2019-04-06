<?php

namespace App\Services\product;

use App\Entity\Modification;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTag(string $title, int $product_id)
    {
        $tag = new Tag();
        $tag->setTitle($title);
        $tag->setProductId($product_id);

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updateTag(string $title, int $product_id)
    {
        $tag = new Tag();
        $tag->setTitle($title);
        $tag->setProductId($product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(Modification $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
    }
}