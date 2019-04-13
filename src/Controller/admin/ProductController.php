<?php

namespace App\Controller\admin;

use App\Entity\Modification;
use App\Entity\Photo;
use App\Entity\Product;
use App\Entity\Tag;
use App\Form\admin\ProductCreateForm;
use App\Form\admin\TagTypeModalForm;
use App\Repository\TagRepository;
use App\Services\product\ModificationService;
use App\Services\product\PhotoService;
use App\Services\product\ProductService;
use App\Services\product\TagService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /** @var ProductService */
    private $productService;

    /** @var ModificationService */
    private $modificationService;

    /** @var TagService */
    private $tagService;

    /** @var PhotoService */
    private $photoService;

    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        ProductService $productService,
        ModificationService $modificationService,
        TagService $tagService,
        PhotoService $photoService,
        TagRepository $tagRepository
    )
    {
        $this->productService = $productService;
        $this->modificationService = $modificationService;
        $this->tagService = $tagService;
        $this->photoService = $photoService;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/", name="view_all_products")
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
     * @Route("/{id}", name="view_one_product", requirements={"id"="\d+"})
     */
    public function viewOneProduct(Product $product, Request $request)
    {
        $tag = new Tag();
        $tagForm = $this->createForm(TagTypeModalForm::class, $tag);
        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            $result = $this->tagService->createTag(
                $tagForm->get('tag_id')->getData(),
                $product->getId()
            );
            if ($result) {
                $this->addFlash('success', 'Метка создана!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }
        return $this->render(
            "admin/product/viwe-one-product.html.twig",
            [
                "product" => $product,
                'tagForm' => $tagForm->createView(),
            ]
        );
    }

    /**
     * @Route("/create", name="create_product")
     */
    public function createProduct(Request $request)
    {
        $product = new Product();
        $modification = new Modification();
        $tag = new Tag();
        $photo = new Photo();

        $product->addModification($modification);
        $product->addTag($tag);
        $product->addPhoto($photo);

        $form = $this->createForm(ProductCreateForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mod = $this->modificationService->createModification(
                $form->get('modification')[0]->get('title')->getData(),
                $form->get('modification')[0]->get('text')->getData()
            );

            $tag = $this->tagService->createTag(
                $form->get('tag')[0]->get('tag_id')->getData()
            );

            $photo = $this->photoService->createPhoto(
                $form->get('photo')[0]->get('name')->getData()
            );

            $result = $this->productService->createProduct(
                $mod,
                $tag,
                $photo,
                $form->get('title')->getData(),
                $form->get('description')->getData(),
                $form->get('price')->getData()
            );

            $this->addFlash('success', 'Товар создан!');
            return $this->redirectToRoute('view_one_product',
                array(
                    'id' => $result->getId()
                )
            );
        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete-tag/{id}", name="delete_tag_modal")
     */
    public function deleteTag(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }
}