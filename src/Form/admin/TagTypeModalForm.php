<?php

namespace App\Form\admin;

use App\Entity\AllTags;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagTypeModalForm extends AbstractType
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag_id', ChoiceType::class, [
                'choices'  => $this->allTags(),
            ])
            ->add('Прикрепить', SubmitType::class);
    }

    private function allTags()
    {
        $em = $this->entityManager;
        $tags = $em->getRepository(AllTags::class)->findAll();

        $result = array();
        foreach ($tags as $key => $values) {
            $result[$values->getTitle()] = $values->getId();
        }
        return $result;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}