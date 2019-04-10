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
     * @Route("/product/create", name="create_product")
     */
    public function createProduct(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductCreateForm::class, $product);
        $form->handleRequest($request);

        $modification = new Modification();

        if ($form->isSubmitted() && $form->isValid()) {
//            $mod = $this->modificationService->createModification(
//                "Test tile",
//                "Test description"
//            );
//            $prod = $this->productService->createProduct(
//                $mod,
//                $form->get('tag')->getData(),
//                $form->get('title')->getData(),
//                $form->get('description')->getData(),
//                $form->get('price')->getData()
//            );

            $modification->setTitle("Test modificatrion");
            $modification->setText("Test text");

            $product->setTitle("Title Product");
            $product->setDescription("Description");
            $product->setPrice(1000);

            $product->setModification($modification);

        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}