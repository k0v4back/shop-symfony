<?php

namespace App\Services\product;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;

class PhotoService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPhoto(string $name)
    {
        $photo = new Photo();
        $photo->setName($name);

        $em = $this->entityManager;
        $em->persist($photo);
        $em->flush();

        return $photo;
    }

    public function updatePhoto(string $name)
    {
        $photo = new Photo();
        $photo->setName($name);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deletePhoto(Photo $photo)
    {
        $em = $this->entityManager;
        $em->remove($photo);
    }
}