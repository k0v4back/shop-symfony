<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\admin\UserCreateForm;
use App\Form\admin\UserEditForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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
     * @Route("/users/update/{id}", name="edit_user", requirements={"id"="\d"})
     */
    public function updateUser(User $user, Request $request)
    {
        $form = $this->createForm(UserEditForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFullname($form->get('fullname')->getData());
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setStatus($form->get('status')->getData());
            $user->setCreatedAt(time());
            $user->setUpdatedAt(time());

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('primary', 'Пользователь обновлён!');

            return $this->redirectToRoute('view_user',
                array(
                    'id' => $user->getId()
                )
            );
        }

        return $this->render('admin/user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/delete/{id}", name="delete_user", requirements={"id"="\d"})
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('primary', 'Пользователь удалён!');

        return $this->redirectToRoute('all_users');
    }

    /**
     * @Route("/users/create", name="create_user")
     */
    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserCreateForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFullname($form->get('fullname')->getData());
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setPassword($this->encoder->encodePassword($user, $form->get('password')->getData()));
            $user->setStatus($form->get('status')->getData());
            $user->setCreatedAt(time());
            $user->setUpdatedAt(time());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Пользователь создан!');

            return $this->redirectToRoute('view_user',
                array(
                    'id' => $user->getId()
                )
            );
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}