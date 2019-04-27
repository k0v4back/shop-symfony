<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BasketRepository")
 */
class Basket
{
    const NOT_BOUGHT = 0;
    const BOUGHT = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="id")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $pricePerItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPricePerItem()
    {
        return $this->pricePerItem;
    }

    public function setPricePerItem($pricePerItem): void
    {
        $this->pricePerItem = $pricePerItem;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
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
