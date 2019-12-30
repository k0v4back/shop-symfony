<?php

namespace App\Form\admin\user;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Активный' => User::IS_ACTIVE,
                    'Неактивный' => User::IS_WAITING
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Пользователь' => User::ROLE_USER,
                    'Администратор' => User::ROLE_ADMIN,
                    'Супер администратор' => User::ROLE_SUPER_ADMIN
                ],
            ])
            ->add('Сохранить', SubmitType::class);

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    return $rolesString;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}