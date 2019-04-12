<?php

namespace App\Services\product;

use App\Entity\Photo;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;

class PhotoService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManager, FileUploader $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    public function createPhoto($file)
    {
        $photo = new Photo();
        $photo->setName($this->fileUploader->upload($file));

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