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
        $em->flush();
    }

    public function moveUp(Product $entityProduct, $sort_id)
    {
        $previous = $this->nextIndex($entityProduct, $sort_id, 2);
        $upper = $this->modificationRepository->findOneBy(['sort' => $sort_id - $previous]);
        $lower = $this->modificationRepository->findOneBy(['sort' => $sort_id]);
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
        $lower = $this->modificationRepository->findOneBy(['sort' => $sort_id+$nexIndex]);
        $default = $this->modificationRepository->findOneBy(['sort' => $sort_id]);
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
                    $res = $all[$key]['sort'] - $all[$key-1]['sort'];
                }
            }
        }
        return $res;
    }
}