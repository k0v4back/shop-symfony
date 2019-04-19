<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ChoiceRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var ChoiceRepository */
    private $choiceRepository;

    public function __construct(
        ProductRepository $productRepository,
        ChoiceRepository $choiceRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->choiceRepository = $choiceRepository;
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

    /**
     * @Route("/product/{id}", name="show_one_product", requirements={"id"="\d+"})
     */
    public function oneProduct(Product $product)
    {
        $choices = $this->choiceRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        return $this->render(
            'one-product.html.twig',
            [
                'product' => $product,
                'choices' => $choices,
            ]
        );
    }
}