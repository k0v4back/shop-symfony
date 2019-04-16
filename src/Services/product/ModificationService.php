<?php

namespace App\Services\product;

use App\Entity\Modification;
use App\Entity\Product;
use App\Repository\ModificationRepository;
use Doctrine\ORM\EntityManagerInterface;

class ModificationService
{
    /** @var EntityManagerInterface */
    private $entityManager;
    
    /** @var ModificationRepository */
    private $modificationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ModificationRepository $modificationRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->modificationRepository = $modificationRepository;
    }

    public function createModification(string $title, $text, Product $product = null)
    {
        if (!$product) {
            $modification = new Modification();
            $modification->setTitle($title);
            $modification->setText($text);
            $modification->setSort(1);
        }
        if ($this->modificationRepository->findMaxSort($product) == null) {
            $modification = new Modification();
            $modification->setTitle($title);
            $modification->setText($text);
            $modification->setProduct($product);
            $modification->setSort(1);
        } else {
            $max = $this->modificationRepository->findMaxSort($product)[0]['sort'];
            $modification = new Modification();
            $modification->setTitle($title);
            $modification->setText($text);
            $modification->setProduct($product);
            $modification->setSort($max+1);
        }

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
        $em->flush();
    }

    public function moveUp(Product $entityProduct, $modificationId, $sort_id)
    {
        $nexIndex = $this->nextIndex($entityProduct, $sort_id, 2);
        $upper = $this->modificationRepository->findOneBy(array('product' => $entityProduct, 'sort' => $sort_id - $nexIndex));
        $default = $this->modificationRepository->findOneBy(array('id' => $modificationId));
        if ($upper && $default) {
            $upper->setSort($upper->getSort()+1);
            $default->setSort($default->getSort()-$nexIndex);

            $em = $this->entityManager;
            $em->persist($upper);
            $em->flush();

            $em2= $this->entityManager;
            $em2->persist($default);
            $em2->flush();
        }
        return $entityProduct;
    }

    public function moveDown(Product $entityProduct, $modificationId, $sort_id)
    {
        $nexIndex = $this->nextIndex($entityProduct, $sort_id, 1);
        $lower = $this->modificationRepository->findOneBy(array('product' => $entityProduct, 'sort' => $sort_id + $nexIndex));
        $default = $this->modificationRepository->findOneBy(array('id' => $modificationId));
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
        $all = $this->modificationRepository->findAllSort($entityProduct);
        $res = null;
        foreach ($all as $key => $value) {
            if ($value['sort'] == $sort_id) {
                if ($condition === 1) {
                    $next = $all[$key+1];
                    $res = $next['sort'] - $sort_id;
                } else {
                    if (isset($all[$key-1]['sort'])) {
                        $res = $all[$key]['sort'] - $all[$key-1]['sort'];
                    } else {
                        $res = $all[$key]['sort'] - 1;
                    }
                }
            }
        }
        return $res;
    }
}