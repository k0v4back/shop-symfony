<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     */
    private $tag_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="tag")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagId()
    {
        return $this->tag_id;
    }

    public function setTagId($tag_id): void
    {
        $this->tag_id = $tag_id;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): void
    {
        $this->product = $product;
    }
}
