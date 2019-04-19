<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homePage()
    {
        $products = $this->productRepository->findAll();
        return $this->render(
            'main-page.html.twig',
            [
                'products' => $products
            ]
        );
    }
}