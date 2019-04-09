<?php

namespace App\Controller\admin;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="view_all_products")
     */
    public function allProducts()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render(
            'admin/product/index.html.twig',
            [
                'products' => $products
            ]
        );
    }
}