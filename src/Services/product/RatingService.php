<?php

namespace App\Services\product;

use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;

class RatingService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createRating(float $assessment, int $product_id, $user_id)
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

    public function updateRating(float $assessment, int $product_id, $user_id)
    {
        $rating = new Rating();
        $rating->setProductId($product_id);
        $rating->setUserId($user_id);
        $rating->setAssessment($assessment);

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteRating(Rating $rating)
    {
        $em = $this->entityManager;
        $em->remove($rating);
    }
}