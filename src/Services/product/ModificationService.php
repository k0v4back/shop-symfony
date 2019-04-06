<?php

namespace App\Services\product;

use App\Entity\Modification;
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
        $modification = new Modification();
        $modification->setTitle($title);
        $modification->setProductId($product_id);

        $em = $this->entityManager;
        $em->persist($modification);
        $em->flush();

        return $modification;
    }

    public function updateModification(string $title, int $product_id)
    {
        $modification = new Modification();
        $modification->setTitle($title);
        $modification->setProductId($product_id);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteModification(Modification $modification)
    {
        $em = $this->entityManager;
        $em->remove($modification);
    }
}