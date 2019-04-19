<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChoiceRepository")
 */
class Choice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $content;

    /**
     * @ORM\Column(type="float", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(max=10)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="choice")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }
}
