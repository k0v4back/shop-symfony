<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelatedProductsRepository")
 */
class RelatedProducts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $related_product_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="relatedProducts")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedProductId(): ?int
    {
        return $this->related_product_id;
    }

    public function setRelatedProductId(int $related_product_id): self
    {
        $this->related_product_id = $related_product_id;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }
}
