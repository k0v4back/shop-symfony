<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PayController extends AbstractController
{
    /** @var BasketRepository */
    public $basketRepository;

    public function __construct
    (
        BasketRepository $basketRepository
    )
    {
        $this->basketRepository = $basketRepository;
    }

    /**
     * @Route("/pay/{id}", name="pay_page")
     */
    public function main(Product $product)
    {
        $all = $this->basketRepository->findOneBy(['product' => $product]);
        return $this->render(
            'pay/index.html.twig',
            [
                'product' => $all,
            ]
        );
    }

    public function buyItem(Product $product)
    {

    }
}