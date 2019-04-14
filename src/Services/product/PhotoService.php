<?php

namespace App\Services\product;

use App\Entity\Photo;
use App\Entity\Product;
use App\Repository\PhotoRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;

class PhotoService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var FileUploader  */
    private $fileUploader;

    /** @var PhotoRepository */
    private $photoRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
        PhotoRepository $photoRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->photoRepository = $photoRepository;
    }

    public function createPhoto($file, Product $product = null)
    {
        if (!$product) {
            $photo = new Photo();
            $photo->setName($this->fileUploader->upload($file));

            $em = $this->entityManager;
            $em->persist($photo);
            $em->flush();

            return $photo;
        }

        $photo = new Photo();
        $photo->setName($this->fileUploader->upload($file));
        $photo->setProduct($product);

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
        $em->flush();
    }

    public function moveUp($product, Product $entityProduct, $sort_id)
    {
//        $max = $this->photoRepository->findMaxSort($product)[0]['sort'];
//        $min = $this->photoRepository->findMinSort($product)[0]['sort'];

        $upper = $this->photoRepository->findOneBy(['sort' => $sort_id-1]);
        $lower = $this->photoRepository->findOneBy(['sort' => $sort_id]);
        if ($upper && $lower) {
            $upper->setSort($upper->getSort()+1);
            $lower->setSort($lower->getSort()-1);

            $em = $this->entityManager;
            $em->persist($upper);
            $em->flush();

            $em2= $this->entityManager;
            $em2->persist($lower);
            $em2->flush();

        }

        return $entityProduct;
    }

    public function moveDown()
    {

    }
}