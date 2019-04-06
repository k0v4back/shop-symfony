<?php

namespace App\Services\modification;

use App\Entity\Modification;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;

class ModificationService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createModification(string $title, int $product_id)
    {
        $photo = new Modification();
        $photo->setTitle($title);
        $photo->setProductId($product_id);

        $em = $this->entityManager;
        $em->persist($photo);
        $em->flush();

        return $photo;
    }

    public function updateModification(string $title, int $product_id)
    {
        $photo = new Modification();
        $photo->setTitle($title);
        $photo->setProductId($product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteModification(Photo $photo)
    {
        $em = $this->entityManager;
        $em->remove($photo);
    }
}