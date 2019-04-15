<?php

namespace App\Form\admin\user;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Активный' => User::IS_ACTIVE,
                    'Неактивный' => User::IS_WAITING
                ],
            ])
            ->add('Сохранить', SubmitType::class);
    }
}