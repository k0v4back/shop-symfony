<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\admin\UserEditForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/users/{id}", name="view_user", requirements={"id"="\d"})
     */
    public function viewUser(User $user)
    {
        return $this->render('admin/user/one-user.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @Route("/users/update/{id}", name="delete_user")
     */
    public function updateUser(User $user, Request $request)
    {
        $form = $this->createForm(UserEditForm::class, $user);
        $form->handleRequest($request);

        $user = new User();

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFullname($form->get('fullname')->getData());
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setStatus($form->get('status')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('admin/user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}