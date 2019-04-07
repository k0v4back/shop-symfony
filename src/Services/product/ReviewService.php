<?php

namespace App\Services\product;

use App\Entity\Rating;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createReview(string $text, int $user_id)
    {
        $rating = new Review();
        $rating->setText($text);
        $rating->setAuthorId($user_id);
        $rating->setCreatedAt(time());

        $em = $this->entityManager;
        $em->persist($rating);
        $em->flush();

        return $rating;
    }

    public function updateReview(string $text, int $user_id)
    {
        $rating = new Review();
        $rating->setText($text);
        $rating->setAuthorId($user_id);
        $rating->setCreatedAt(time());

        $em = $this->entityManager;
        $em->flush();
    }

    public function deleteReview(Rating $rating)
    {
        $em = $this->entityManager;
        $em->remove($rating);
    }
}