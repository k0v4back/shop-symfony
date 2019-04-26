<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PayController extends AbstractController
{
    /**
     * @Route("/pay/{id}/{quantity}/{price}", name="pay_page")
     */
    public function main(Product $product, $quantity, $price)
    {
        return $this->render(
            'pay/index.html.twig',
            [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price
            ]
        );
    }
}