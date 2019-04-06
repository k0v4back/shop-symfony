<?php

namespace App\Services\rating;

use App\Entity\Rating;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ProductReviewService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createReview(int $product_id, $user_id)
    {
        $rating = new Review();
        $rating->setText($product_id);
        $rating->setAuthorId($user_id);
        $rating->setCreatedAt(time());

        $em = $this->entityManager;
        $em->persist($rating);
        $em->flush();

        return $rating;
    }

    public function updateReview(int $product_id, $user_id)
    {
        $rating = new Review();
        $rating->setText($product_id);
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