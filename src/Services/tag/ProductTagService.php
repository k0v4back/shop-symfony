<?php

namespace App\Services\tag;

use App\Entity\Modification;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class ProductTagService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPhoto(string $title, int $product_id)
    {
        $tag = new Tag();
        $tag->setTitle($title);
        $tag->setProductId($product_id);

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updatePhoto(string $title, int $product_id)
    {
        $tag = new Tag();
        $tag->setTitle($title);
        $tag->setProductId($product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deletePhoto(Modification $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
    }
}