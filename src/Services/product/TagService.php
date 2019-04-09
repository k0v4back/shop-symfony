<?php

namespace App\Services\product;

use App\Entity\Modification;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTag(string $title)
    {
        $tag = new Tag();
        $tag->setTitle($title);

        $em = $this->entityManager;
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function updateTag(string $title)
    {
        $tag = new Tag();
        $tag->setTitle($title);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteTag(Tag $tag)
    {
        $em = $this->entityManager;
        $em->remove($tag);
        $em->flush();
    }
}