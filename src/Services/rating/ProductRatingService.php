<?php

namespace App\Services\rating;

use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;

class ProductRatingService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPhoto(float $assessment, int $product_id, $user_id)
    {
        $rating = new Rating();
        $rating->setProductId($product_id);
        $rating->setUserId($user_id);
        $rating->setAssessment($assessment);

        $em = $this->entityManager;
        $em->persist($rating);
        $em->flush();

        return $rating;
    }

    public function updatePhoto(float $assessment, int $product_id, $user_id)
    {
        $rating = new Rating();
        $rating->setProductId($product_id);
        $rating->setUserId($user_id);
        $rating->setAssessment($assessment);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deletePhoto(Rating $rating)
    {
        $em = $this->entityManager;
        $em->remove($rating);
    }
}