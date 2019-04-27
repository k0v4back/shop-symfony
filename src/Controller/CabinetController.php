<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PurchasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{
    /** @var PurchasesRepository */
    private $purchasesRepository;

    public function __construct
    (
        PurchasesRepository $purchasesRepository
    )
    {
        $this->purchasesRepository = $purchasesRepository;
    }

    /**
     * @Route("/cabinet/{id}", name="user_cabinet", requirements={"id"="\d+"})
     */
    public function main(User $user)
    {
        if ($this->checkAccess() == true) {
            $purchases = $this->purchasesRepository->findBy(['user' => $user]);
            return $this->render('cabinet.html.twig',
                [
                    'user' => $user,
                    'purchases' => $purchases
                ]
            );
        }
    }

    public function checkAccess()
    {
        if (!isset($user)) {
            return $this->redirectToRoute('homepage');
        }

        if (isset($user)) {
            if ($this->getUser()->getId() != $user->getId()) {
                return $this->redirectToRoute('homepage');
            }
        }
        return true;
    }
}