<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /** @var EntityManagerInterface  */
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadCategories($manager);
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("k0v4");
        $user->setFullname("Kosolapov Vadim");
        $user->setEmail("vadkos33@outlook.com");
        $user->setStatus(User::IS_ACTIVE);
        $user->setRoles(User::ROLE_SUPER_ADMIN);
        $user->setPassword($this->encoder->encodePassword($user, 111111));
        $user->setCreatedAt(time());
        $user->setUpdatedAt(time());

        $this->addReference('k0v4', $user);


        $user2 = new User();
        $user2->setUsername("admin");
        $user2->setFullname("Admin Admin");
        $user2->setEmail("admin@admin.com");
        $user2->setStatus(User::IS_ACTIVE);
        $user2->setRoles(User::ROLE_ADMIN);
        $user2->setPassword($this->encoder->encodePassword($user, 111111));
        $user2->setCreatedAt(time());
        $user2->setUpdatedAt(time());

        $this->addReference('k0v42', $user);

        $user3 = new User();
        $user3->setUsername("user");
        $user3->setFullname("User User");
        $user3->setEmail("user@user.com");
        $user3->setStatus(User::IS_ACTIVE);
        $user3->setRoles(User::ROLE_USER);
        $user3->setPassword($this->encoder->encodePassword($user, 111111));
        $user3->setCreatedAt(time());
        $user3->setUpdatedAt(time());

        $this->addReference('k0v43', $user);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);


        $manager->flush();
    }

    public function loadCategories(ObjectManager $manager)
    {
        $category = new Category();
        $category->setSlug('computers');
        $category->setTitle('Компьюторы');

        $category2 = new Category();
        $category2->setSlug('home');
        $category2->setTitle('Для дома');

        $types = new Category();
        $types->setParent($category);
        $types->setSlug('notebooks');
        $types->setTitle('Ноутбуки');

        $types2 = new Category();
        $types2->setParent($category);
        $types2->setSlug('categories');
        $types2->setTitle('Пк');

        $types3 = new Category();
        $types3->setParent($types2);
        $types3->setSlug('any-more');
        $types3->setTitle('Комплектующие');

        $em = $this->entityManager;
        $em->persist($category);
        $em->persist($category2);
        $em->persist($types);
        $em->persist($types2);
        $em->persist($types3);
        $em->flush();
    }
}
