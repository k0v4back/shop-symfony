<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Form\admin\ProductCreateForm;
use App\Services\product\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ProductController extends AbstractController
{
    /** @var ProductService */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
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

    /**
     * @Route("/product/create", name="create_product")
     */
    public function createProduct(Request $request)
    {
        $tag = new Product();
        $form = $this->createForm(ProductCreateForm::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->productService->createProduct(
                $form->get('modification')->getData(),
                $form->get('tag')->getData(),
                $form->get('title')->getData(),
                $form->get('description')->getData(),
                $form->get('price')->getData()
            );
            if ($result) {
                $this->addFlash('success', 'Продукт создан!');
                return $this->redirectToRoute('view_all_products');
            }
        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}