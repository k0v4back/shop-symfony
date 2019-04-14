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
            $photo->setSort(1);

            $em = $this->entityManager;
            $em->persist($photo);
            $em->flush();

            return $photo;
        }
        if ($this->photoRepository->findMaxSort($product) == null) {
            $photo = new Photo();
            $photo->setName($this->fileUploader->upload($file));
            $photo->setProduct($product);
            $photo->setSort(1);
        } else {
            $max = $this->photoRepository->findMaxSort($product)[0]['sort'];
            $photo = new Photo();
            $photo->setName($this->fileUploader->upload($file));
            $photo->setProduct($product);
            $photo->setSort($max+1);
        }

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

    public function moveUp(Product $entityProduct, $sort_id)
    {
        $previous = $this->nextIndex($entityProduct, $sort_id, 2);
        $upper = $this->photoRepository->findOneBy(['sort' => $sort_id - $previous]);
        $lower = $this->photoRepository->findOneBy(['sort' => $sort_id]);
        if ($upper && $lower) {
            $upper->setSort($upper->getSort()+1);
            $lower->setSort($lower->getSort()-$previous);

            $em = $this->entityManager;
            $em->persist($upper);
            $em->flush();

            $em2= $this->entityManager;
            $em2->persist($lower);
            $em2->flush();
        }
        return $entityProduct;
    }

    public function moveDown(Product $entityProduct, $sort_id)
    {
        $nexIndex = $this->nextIndex($entityProduct, $sort_id, 1);
        $lower = $this->photoRepository->findOneBy(['sort' => $sort_id+$nexIndex]);
        $default = $this->photoRepository->findOneBy(['sort' => $sort_id]);
        if ($default && $lower) {
            $default->setSort($default->getSort()+$nexIndex);
            $lower->setSort($lower->getSort()-1);

            $em = $this->entityManager;
            $em->persist($default);
            $em->flush();

            $em2= $this->entityManager;
            $em2->persist($lower);
            $em2->flush();
        }
        return $entityProduct;
    }

    public function nextIndex(Product $entityProduct, $sort_id, $condition)
    {
        $all = $this->photoRepository->findAllSort($entityProduct);
        $res = null;
        foreach ($all as $key => $value) {
            if ($value['sort'] == $sort_id) {
                if ($condition === 1) {
                    $next = $all[$key+1];
                    $res = $next['sort'] - $sort_id;
                } else {
                    $res = $all[$key]['sort'] - $all[$key-1]['sort'];
                }
            }
        }
        return $res;
    }
}