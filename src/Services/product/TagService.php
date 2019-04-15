<?php

namespace App\Services\product;

use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ProductRepository  */
    private $productRepository;
    
    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
        TagRepository $tagRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
    }

    public function createTag(int $tagId, $productId = null)
    {
        if (!$productId) {
            $tag = new Tag();
            $tag->setTagId($tagId);
            $tag->setSort(1);

            $em = $this->entityManager;
            $em->persist($tag);
            $em->flush();

            return $tag;
        }
        $product = $this->productRepository->find($productId);
        if ($this->tagRepository->findMaxSort($product) == null) {
            $tag = new Tag();
            $tag->setTagId($tagId);
            $tag->setProduct($product);
            $tag->setSort(1);
        } else {
            $max = $this->tagRepository->findMaxSort($product)[0]['sort'];
            $tag = new Tag();
            $tag->setTagId($tagId);
            $tag->setProduct($product);
            $tag->setSort($max+1);
        }

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updateTag(int $tagId)
    {
        $tag = new Tag();
        $tag->setTagId($tagId);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(Tag $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
        $em->flush();
    }

    public function moveUp(Product $entityProduct, $sort_id)
    {
        $previous = $this->nextIndex($entityProduct, $sort_id, 2);
        $upper = $this->tagRepository->findOneBy(['sort' => $sort_id - $previous]);
        $lower = $this->tagRepository->findOneBy(['sort' => $sort_id]);
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
        $lower = $this->tagRepository->findOneBy(['sort' => $sort_id+$nexIndex]);
        $default = $this->tagRepository->findOneBy(['sort' => $sort_id]);
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
        $all = $this->tagRepository->findAllSort($entityProduct);
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