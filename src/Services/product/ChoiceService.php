<?php

namespace App\Services\product;

use App\Entity\Choice;
use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\ChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChoiceService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ChoiceRepository  */
    private $choiceRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ChoiceRepository $choiceRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->choiceRepository = $choiceRepository;
    }

    public function createChoice($content, $productId = null)
    {
        if (!$productId) {
            $tag = new Choice();
            $tag->setContent($content);
            $tag->setSort(1);

            $em = $this->entityManager;
            $em->persist($tag);
            $em->flush();

            return $tag;
        }
        $product = $this->choiceRepository->find($productId);
        if ($this->choiceRepository->findMaxSort($product) == null) {
            $tag = new Choice();
            $tag->setContent($content);
            $tag->setProduct($product);
            $tag->setSort(1);
        } else {
            $max = $this->choiceRepository->findMaxSort($product)[0]['sort'];
            $tag = new Choice();
            $tag->setContent($content);
            $tag->setProduct($product);
            $tag->setSort($max+1);
        }

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updateChoice($content)
    {
        $tag = new Choice();
        $tag->setContent($content);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(Choice $choice)
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