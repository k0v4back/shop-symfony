<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketRepository;
use App\Services\basket\BasketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    /** @var BasketRepository */
    private $basketRepository;

    /** @var BasketService */
    private $basketService;

    public function __construct
    (
        BasketRepository $basketRepository,
        BasketService $basketService
    )
    {
        $this->basketRepository = $basketRepository;
        $this->basketService = $basketService;
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

    /**  */
    public function changeQuantity()
    {

    }
}