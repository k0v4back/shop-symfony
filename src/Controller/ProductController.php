<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ChoiceRepository;
use App\Repository\PhotoRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var ChoiceRepository */
    private $choiceRepository;

    /** @var PhotoRepository */
    private $photoRepository;

    public function __construct(
        ProductRepository $productRepository,
        ChoiceRepository $choiceRepository,
        PhotoRepository $photoRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->choiceRepository = $choiceRepository;
        $this->photoRepository = $photoRepository;
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
        $photos = $this->photoRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        return $this->render(
            'one-product.html.twig',
            [
                'product' => $product,
                'choices' => $choices,
                'photos' => $photos,
            ]
        );
    }
}