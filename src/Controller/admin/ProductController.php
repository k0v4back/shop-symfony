<?php

namespace App\Controller\admin;

use App\Entity\Modification;
use App\Entity\Product;
use App\Form\admin\ProductCreateForm;
use App\Services\product\ModificationService;
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

    /** @var ModificationService */
    private $modificationService;

    public function __construct(
        ProductService $productService,
        ModificationService $modificationService
    )
    {
        $this->productService = $productService;
        $this->modificationService = $modificationService;
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
     * @Route("/product/{id}", name="view_one_product", requirements={"id"="\d+"})
     */
    public function viewOneProduct(Product $product)
    {
        return $this->render(
            "admin/product/viwe-one-product.html.twig",
            [
                "product" => $product
            ]
        );
    }

    /**
     * @Route("/product/create", name="create_product")
     */
    public function createProduct(Request $request)
    {
        $product = new Product();

        $modification = new Modification();

        $product->addModification($modification);

        $form = $this->createForm(ProductCreateForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mod = $this->modificationService->createModification(
                $form->get('modification')[0]->get('title')->getData(),
                $form->get('modification')[0]->get('text')->getData()
            );

            $prod = $this->productService->createProduct(
                $mod,
                $form->get('title')->getData(),
                $form->get('description')->getData(),
                $form->get('price')->getData()
            );

            $modification->setTitle("Test modificatrion");
            $modification->setText("Test text");

            $product->setTitle("Title Product");
            $product->setDescription("Description");
            $product->setPrice(1000);

        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}