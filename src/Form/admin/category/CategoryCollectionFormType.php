<?php

namespace App\Form\admin\category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\StandartCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryCollectionFormType extends AbstractType
{
    /** @var StandartCategoryRepository */
    private $categoryRepository;

    public function __construct(StandartCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->createArrCategories();
        $builder
            ->add('product', ChoiceType::class, [
            'choices' => $this->createArrCategories()
            ]);
    }

    public function createArrCategories()
    {
        $rawCategories = $this->categoryRepository->findAllCategories();
        $result = array();
        foreach ($rawCategories as $key => $value) {
            $result += [str_repeat('------', $value['lvl']).$value['title'] => $value['id']];
        }
        return $result;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}