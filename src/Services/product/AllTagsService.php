<?php

namespace App\Services\product;

use App\Entity\AllTags;
use Doctrine\ORM\EntityManagerInterface;

class AllTagsService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTag(string $title)
    {
        $tag = new AllTags();
        $tag->setTitle($title);

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updateTag(string $title)
    {
        $tag = new AllTags();
        $tag->setTitle($title);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(AllTags $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
        $em->flush();
    }
}