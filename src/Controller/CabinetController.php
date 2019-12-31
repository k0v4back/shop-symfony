<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BasketRepository;
use App\Repository\PurchasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{
    /** @var PurchasesRepository */
    private $purchasesRepository;

    /** @var BasketRepository */
    private $basketRepository;

    public function __construct
    (
        PurchasesRepository $purchasesRepository,
        BasketRepository $basketRepository
    )
    {
        $this->purchasesRepository = $purchasesRepository;
        $this->basketRepository = $basketRepository;
    }

    /**
     * @Route("/cabinet/{id}", name="user_cabinet", requirements={"id"="\d+"})
     */
    public function main(User $user)
    {
        if(null ==  $this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        if ($this->checkAccess() == true) {

            $currentUserId = $this->getUser()->getId();
            if ($user->getId() !== $currentUserId) {
                return $this->redirectToRoute('homepage');
            }

            $items = $this->basketRepository->findWithProductForUserOrders($user);
            return $this->render('cabinet.html.twig',
                [
                    'user' => $user,
                    'items' => $items
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