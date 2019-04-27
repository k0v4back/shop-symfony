<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\Purchases;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PayController extends AbstractController
{
    /** @var BasketRepository */
    private $basketRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct
    (
        BasketRepository $basketRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->basketRepository = $basketRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/pay/{id}", name="pay_page", requirements={"id"="\d+"})
     */
    public function main(Product $product)
    {
        $all = $this->basketRepository->findOneBy(['product' => $product]);
        return $this->render(
            'pay/index.html.twig',
            [
                'all' => $all,
                'product' => $product,
            ]
        );
    }

    /**
     * @Route("/buy/{id}", name="buy_action", requirements={"id"="\d+"})
     */
    public function buyItem(Product $product)
    {
        if ($this->checkAccess() == true) {
            $basket = $this->basketRepository->findOneBy(['product' => $product]);
            $em = $this->entityManager;

            $purchases = new Purchases();
            $purchases->setBasket($basket);
            $purchases->setCreatedAt(time());
            $em->persist($purchases);

            $basket->setStatus(Basket::BOUGHT);
            $em->persist($basket);

            $em->flush();

            $this->addFlash('success', 'Покупка совершена!');
            return $this->redirectToRoute('homepage');
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