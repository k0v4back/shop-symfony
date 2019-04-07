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

    public function createRating(float $assessment, int $user_id)
    {
        $rating = new Rating();
        $rating->setUserId($user_id);
        $rating->setAssessment($assessment);

        $em = $this->entityManager;
        $em->persist($rating);
        $em->flush();

        return $rating;
    }

    public function updateRating(float $assessment, int $user_id)
    {
        $rating = new Rating();
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