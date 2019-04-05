<?php

namespace App\Controller\admin;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="all_users")
     */
    public function allUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/users/{id}", name="user_by_id", requirements={"id"="\d"})
     */
    public function showUser(User $user)
    {
        return $this->render('admin/user/one-user.html.twig',[
            'user' => $user
        ]);
    }
}