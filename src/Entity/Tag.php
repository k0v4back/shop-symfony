<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $tag_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="tag")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getTagId()
    {
        return $this->tag_id;
    }

    public function setTagId($tag_id): void
    {
        $this->tag_id = $tag_id;
    }
}
