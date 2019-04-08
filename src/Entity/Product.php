<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modification", inversedBy="product")
     */
    private $modification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="product")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag", inversedBy="product")
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelatedProducts", mappedBy="product")
     */
    private $relatedProducts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rating", inversedBy="product")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $review;

    public function __construct() {
        $this->review = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
    }

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

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    public function getModification()
    {
        return $this->modification;
    }

    public function setModification($modification): void
    {
        $this->modification = $modification;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag): void
    {
        $this->tag = $tag;
    }

    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    public function setRelatedProducts($relatedProducts): void
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function setReview($review): void
    {
        $this->review = $review;
    }
}
