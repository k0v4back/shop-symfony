<?php

namespace App\Controller;

use App\Entity\AllTags;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\ChoiceRepository;
use App\Repository\PhotoRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
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

    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        ProductRepository $productRepository,
        ChoiceRepository $choiceRepository,
        PhotoRepository $photoRepository,
        TagRepository $tagRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->choiceRepository = $choiceRepository;
        $this->photoRepository = $photoRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homePage()
    {
        $products = $this->productRepository->findAll();

        $em = $this->getDoctrine()->getManager();
        $categoryEntity = $em->getRepository(Category::class);
        $categories = $categoryEntity->childrenHierarchy();

        return $this->render(
            'main-page.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
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

    /**
     * @Route("/products/tag/{id}", name="search_by_tag", requirements={"id"="\d+"})
     */
    public function searchByTag(AllTags $Alltags)
    {
        $products = $this->productRepository->findAllProductsByTags($Alltags);
        $em = $this->getDoctrine()->getManager();
        $categoryEntity = $em->getRepository(Category::class);
        $categories = $categoryEntity->childrenHierarchy();
        return $this->render(
            'main-page.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
            ]
        );
    }

    /**
     * @Route("/products/category/{id}", name="search_by_category", requirements={"id"="\d+"})
     */
    public function searchByCategory(Category $category)
    {
        $products = $this->productRepository->findBy(['category' => $category]);
        $em = $this->getDoctrine()->getManager();
        $categoryEntity = $em->getRepository(Category::class);
        $categories = $categoryEntity->childrenHierarchy();
        return $this->render(
            'main-page.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
            ]
        );
    }
}