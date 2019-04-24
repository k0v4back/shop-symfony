<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketRepository;
use App\Services\basket\BasketService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    /** @var BasketRepository */
    private $basketRepository;

    /** @var BasketService */
    private $basketService;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct
    (
        BasketRepository $basketRepository,
        BasketService $basketService,
        EntityManagerInterface $entityManager

    )
    {
        $this->basketRepository = $basketRepository;
        $this->basketService = $basketService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/basket/{id}", name="main_basket_page")
     */
    public function mainPage(User $user)
    {
        $items = $this->basketRepository->findWithProduct($user);
        return $this->render(
            'basket.html.twig',
            [
                'items' => $items
            ]
        );
    }

    /**
     * @Route("/basket/{quantity}/{pricePerItem}/{user}/{product}", name="add_to_basket")
     */
    public function addToBasket(int $quantity, int $pricePerItem, Product $product, User $user = null)
    {
        if (isset($quantity, $pricePerItem, $user, $product)) {
            $result = $this->basketService->createBasket($quantity, $pricePerItem, $user, $product);
            if (!$result) {
                throw new \Exception("Error of adding product to basket");
            }
            $arrData = ['output' => 1];
            return new JsonResponse($arrData);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/basket/up/{basketId}/{quantity}", name="up_quantity")
     */
    public function changeQuantity($basketId, $quantity)
    {
        $basket = $this->basketRepository->findOneBy(['id' => $basketId]);

        if (($basket->getQuantity() + $quantity) == 0) {
            $arrData = ['output' => 1];
            return new JsonResponse($arrData);
        }

        $basket->setQuantity($basket->getQuantity() + $quantity);
        $em = $this->entityManager;
        $em->flush();

        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }
}