<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("k0v4");
        $user->setFullname("Kosolapov Vadim");
        $user->setEmail("vadkos33@outlook.com");
        $user->setStatus(User::IS_ACTIVE);
        $user->setPassword($this->encoder->encodePassword($user, 111111));
        $user->setCreatedAt(time());
        $user->setUpdatedAt(time());

        $this->addReference('k0v4', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
