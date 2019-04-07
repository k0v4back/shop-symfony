<?php

namespace App\Form\admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryForm extends AbstractType
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCategory($title)
    {
        $em = $this->entityManager;
        $allCategories = $em->getRepository(Category::class)->findOneBy([
            'title' => $title
        ]);
        return [
            'Основная' => null,
            'Test' => $allCategories
        ];

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('parent', ChoiceType::class, [
                'choices' => $this->getAllCategory('ХЗ')
            ])
            ->add('Создать', SubmitType::class);
    }
}