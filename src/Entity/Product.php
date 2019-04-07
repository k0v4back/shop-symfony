<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=150)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=150)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="float", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(max=10)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modification", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $modification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tag", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelatedProducts", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $relatedProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $review;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }
}
