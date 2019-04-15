<?php

namespace App\Services\product;

use App\Entity\Modification;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ModificationService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createModification(string $title, $text, Product $product = null)
    {
        if (!$product) {
            $modification = new Modification();
            $modification->setTitle($title);
            $modification->setText($text);

            $em = $this->entityManager;
            $em->persist($modification);
            $em->flush();

            return $modification;
        }
        $modification = new Modification();
        $modification->setTitle($title);
        $modification->setText($text);
        $modification->setProduct($product);

        $em = $this->entityManager;
        $em->persist($modification);
        $em->flush();

        return $modification;
    }

    public function updateModification(string $title, $text)
    {
        $modification = new Modification();
        $modification->setTitle($title);
        $modification->setText($text);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteModification(Modification $modification)
    {
        $em = $this->entityManager;
        $em->remove($modification);
    }
}