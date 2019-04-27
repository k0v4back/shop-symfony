<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchasesRepository")
 */
class Purchases
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Basket", inversedBy="id")
     */
    private $basket;

    /**
     * @ORM\Column(type="string")
     */
    private $track;

    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasket(): ?string
    {
        return $this->basket;
    }

    public function setBasket($basket): void
    {
        $this->basket = $basket;
    }

    public function getTrack()
    {
        return $this->track;
    }

    public function setTrack($track): void
    {
        $this->track = $track;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
