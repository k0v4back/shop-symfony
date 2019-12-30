<?php

namespace App\Services\product;

use App\Entity\Choice;
use App\Entity\Product;
use App\Repository\ChoiceRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChoiceService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ChoiceRepository  */
    private $choiceRepository;

    /** @var ProductRepository  */
    private $productRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ChoiceRepository $choiceRepository,
        ProductRepository $productRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->choiceRepository = $choiceRepository;
        $this->productRepository = $productRepository;
    }

    public function createChoice($content, $price, $productId = null)
    {
        if (!$productId) {
            $choice = new Choice();
            $choice->setContent($content);
            $choice->setPrice($price);
            $choice->setSort(1);

            $em = $this->entityManager;
            $em->persist($choice);
//            $em->flush();

            return $choice;
        }
        $product = $this->productRepository->find($productId);
        if ($this->choiceRepository->findMaxSort($product) == null) {
            $choice = new Choice();
            $choice->setContent($content);
            $choice->setPrice($price);
            $choice->setProduct($product);
            $choice->setSort(1);
        } else {
            $max = $this->choiceRepository->findMaxSort($product)[0]['sort'];
            $choice = new Choice();
            $choice->setContent($content);
            $choice->setPrice($price);
            $choice->setProduct($product);
            $choice->setSort($max+1);
        }

        $em = $this->entityManager;
        $em->persist($choice);
        $em->flush();

        return $choice;
    }

    public function updateChoice($content, $price)
    {
        $choice = new Choice();
        $choice->setContent($content);
        $choice->setPrice($price);

        $em = $this->entityManager;
        $em->flush();

        return $choice;
    }

    public function deleteChoice(Choice $choice)
    {
        $em = $this->entityManager;
        $em->remove($choice);
        $em->flush();
    }

    public function moveUp(Product $entityProduct, $choiceId, $sort_id)
    {
        $nexIndex = $this->nextIndex($entityProduct, $sort_id, 2);
        $upper = $this->choiceRepository->findOneBy(array('product' => $entityProduct, 'sort' => $sort_id - $nexIndex));
        $default = $this->choiceRepository->findOneBy(array('id' => $choiceId));
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

    public function moveDown(Product $entityProduct, $choiceId, $sort_id)
    {
        $nexIndex = $this->nextIndex($entityProduct, $sort_id, 1);
        $lower = $this->choiceRepository->findOneBy(array('product' => $entityProduct, 'sort' => $sort_id + $nexIndex));
        $default = $this->choiceRepository->findOneBy(array('id' => $choiceId));
        if ($lower && $default) {
            $default->setSort($default->getSort()+$nexIndex);
            $lower->setSort($lower->getSort()-1);

            $em = $this->entityManager;
            $em->persist($lower);
            $em->flush();

            $em2= $this->entityManager;
            $em2->persist($default);
            $em2->flush();
        }
        return $entityProduct;
    }

    public function nextIndex(Product $entityProduct, $sort_id, $condition)
    {
        $all = $this->choiceRepository->findAllSort($entityProduct);
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