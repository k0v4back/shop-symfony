<?php

namespace App\Helpers;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryChoices
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCategory()
    {
        $em = $this->entityManager;
        $allCategories = $em->getRepository(Category::class)->findAll();

        return [
            'choices'  => [
                'Основная' => null,
                'Test' => "Test"
            ],
        ];
    }
}