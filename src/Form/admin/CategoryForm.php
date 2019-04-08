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

    public function getAllCategory()
    {
        $em = $this->entityManager;
//        $allCategories = $em->getRepository(Category::class)->findOneBy([
//            'title' => $title
//        ]);
        $repo = $em->getRepository(Category::class)->childrenHierarchy();
        $result = array();
        $result += ['Основная' => null];
        foreach ($repo as $key => $value) {
            $categoryByTitle = $em->getRepository(Category::class)->createQueryBuilder($value['title']);
//            var_dump($em->getRepository(Category::class)->getRootNodesQueryBuilder());die();
//            $find = $em->getRepository(Category::class)->find($value['id']);
            $result += [$value['title'] => $em->getRepository(Category::class)->getRootNodesQueryBuilder()];
        }

//        var_dump($repo);die();

        return $result;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('parent', ChoiceType::class, [
                'choices' => $this->getAllCategory()
            ])
            ->add('Создать', SubmitType::class);
    }
}