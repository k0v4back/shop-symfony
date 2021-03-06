<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\Choice;
use App\Entity\Discount;
use App\Entity\Modification;
use App\Entity\Photo;
use App\Entity\Product;
use App\Entity\Tag;
use App\Form\admin\category\CategoryFormType;
use App\Form\admin\choice\ChoiceCreateModalType;
use App\Form\admin\choice\ChoiceEditModalType;
use App\Form\admin\discount\DiscountFormType;
use App\Form\admin\modification\ModificationCreateModalType;
use App\Form\admin\photo\PhotoModalCreateType;
use App\Form\admin\product\ProductCreateType;
use App\Form\admin\product\ProductMainType;
use App\Form\admin\tag\TagModalType;
use App\Repository\ChoiceRepository;
use App\Repository\DiscountRepository;
use App\Repository\ModificationRepository;
use App\Repository\PhotoRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use App\Services\product\ChoiceService;
use App\Services\product\DiscountService;
use App\Services\product\ModificationService;
use App\Services\product\PhotoService;
use App\Services\product\ProductService;
use App\Services\product\TagService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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

    /** @var PhotoRepository */
    private $photoRepository;

    /** @var ProductRepository */
    private $productRepository;

    /** @var ModificationRepository */
    private $modificationRepository;

    /** @var ChoiceService */
    private $choiceService;

    /** @var ChoiceRepository */
    private $choiceRepository;

    /** @var CategoryFormType */
    private $categoryFormType;

    /** @var DiscountService */
    private $discountService;

    /** @var DiscountRepository */
    private $discountRepository;

    /** @var EntityManagerInterface */
    private $entityManager;


    public function __construct(
        ProductService $productService,
        ModificationService $modificationService,
        TagService $tagService,
        PhotoService $photoService,
        TagRepository $tagRepository,
        PhotoRepository $photoRepository,
        ProductRepository $productRepository,
        ModificationRepository $modificationRepository,
        ChoiceService $choiceService,
        ChoiceRepository $choiceRepository,
        CategoryFormType $categoryFormType,
        DiscountService $discountService,
        DiscountRepository $discountRepository
    )
    {
        $this->productService = $productService;
        $this->modificationService = $modificationService;
        $this->tagService = $tagService;
        $this->photoService = $photoService;
        $this->tagRepository = $tagRepository;
        $this->photoRepository = $photoRepository;
        $this->productRepository = $productRepository;
        $this->modificationRepository = $modificationRepository;
        $this->choiceService = $choiceService;
        $this->choiceRepository = $choiceRepository;
        $this->categoryFormType = $categoryFormType;
        $this->discountService = $discountService;
        $this->discountRepository = $discountRepository;
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
        $tagForm = $this->createForm(TagModalType::class, $tag);
        $tagForm->handleRequest($request);

        $photo = new Photo();
        $photoForm = $this->createForm(PhotoModalCreateType::class, $photo);
        $photoForm->handleRequest($request);

        $modification = new Modification();
        $modificationForm = $this->createForm(ModificationCreateModalType::class, $modification);
        $modificationForm->handleRequest($request);

        $choice = new Choice();
        $choiceForm = $this->createForm(ChoiceCreateModalType::class, $choice);
        $choiceForm->handleRequest($request);

        $category = new Category();
        $categoryForm = $this->createForm(CategoryFormType::class, $category);
        $categoryForm->handleRequest($request);

        $discount = new Discount();
        $discountForm = $this->createForm(DiscountFormType::class, $discount);
        $discountForm->handleRequest($request);

        $editProductForm = $this->createForm(ProductMainType::class, $product);
        $editProductForm->handleRequest($request);

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

        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            $result = $this->photoService->createPhoto(
                $photoForm->get('name')->getData(),
                $product
            );
            if ($result) {
                $this->addFlash('success', 'Фотографии загружены!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        if ($modificationForm->isSubmitted() && $modificationForm->isValid()) {
            $result = $this->modificationService->createModification(
                $modificationForm->get('title')->getData(),
                $modificationForm->get('text')->getData(),
                $product
            );
            if ($result) {
                $this->addFlash('success', 'Модификация добавлена!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        if ($choiceForm->isSubmitted() && $choiceForm->isValid()) {
            $result = $this->choiceService->createChoice(
                $choiceForm->get('content')->getData(),
                $choiceForm->get('price')->getData(),
                $product->getId()
            );
            if ($result) {
                $this->addFlash('success', 'Модификация добавлена!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        if ($discountForm->isSubmitted() && $discountForm->isValid())
        {
            $result = $this->discountService->createDiscount(
                $product,
                $discountForm->get('percent')->getData()
            );
            if($result){
                $this->addFlash('success', 'Скидка добалена!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $result = $this->productService->addCategory(
                $categoryForm->get('product')->getData(),
                $product
            );
            if ($result) {
                $this->addFlash('success', 'Категория обновлена!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        if ($editProductForm->isSubmitted() && $editProductForm->isValid()) {
            $result = $this->productService->updateProduct(
                $editProductForm->get('title')->getData(),
                $editProductForm->get('description')->getData()
            );
            if ($result) {
                $this->addFlash('success', 'Товар обновлён!');
                return $this->redirectToRoute('view_one_product',
                    array(
                        'id' => $product->getId()
                    )
                );
            }
        }

        $photos = $this->photoRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        $modifications = $this->modificationRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        $tags = $this->tagRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        $choices = $this->choiceRepository->findBy(['product' => $product], array('sort' => 'ASC'));
        $discount = $this->discountRepository->findOneBy(['product' => $product]);

        return $this->render(
            "admin/product/viwe-one-product.html.twig",
            [
                "product" => $product,
                'tagForm' => $tagForm->createView(),
                'photoForm' => $photoForm->createView(),
                'photos' => $photos,
                'modificationForm' => $modificationForm->createView(),
                'modifications' => $modifications,
                'tags' => $tags,
                'editProductForm' => $editProductForm->createView(),
                'choiceForm' => $choiceForm->createView(),
                'choices' => $choices,
                'categoryForm' => $categoryForm->createView(),
                'discount' => $discount,
                'discountForm' => $discountForm->createView(),
            ]
        );
    }

    /**
     * @Route("/create", name="create_product")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function createProduct(Request $request)
    {
        $product = new Product();
        $modification = new Modification();
        $tag = new Tag();
        $photo = new Photo();
        $choice = new Choice();

        $product->addModification($modification);
        $product->addTag($tag);
        $product->addPhoto($photo);
        $product->addChoice($choice);

        $form = $this->createForm(ProductCreateType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mod = $this->modificationService->createModification(
                $form->get('modification')[0]->get('title')->getData(),
                $form->get('modification')[0]->get('text')->getData()
            );

            if(isset($form->get('tag')[0])){
                $tag = $this->tagService->createTag(
                    $form->get('tag')[0]->get('tag_id')->getData(),
                    $product->getId()
                );
            }

            $photo = $this->photoService->createPhoto(
                $form->get('photo')[0]->get('name')->getData()
            );

            $choice = $this->choiceService->createChoice(
                $form->get('choice')[0]->get('content')->getData(),
                $form->get('choice')[0]->get('price')->getData()
            );

            $result = $this->productService->createProduct(
                $mod,
                $tag,
                $photo,
                $choice,
                $form->get('title')->getData(),
                $form->get('description')->getData()
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
     * @Route("/delete-product/{id}", name="delete_product")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deleteProduct(Product $product)
    {
        $this->productService->deleteProduct($product);
        $this->addFlash('primary', 'Товар удалён!');
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/delete-tag/{id}", name="delete_tag_modal", requirements={"id"="\d+"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deleteTag(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/delete-photo/{id}", name="delete_photo", requirements={"id"="\d+"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deletePhoto(Photo $photo)
    {
        $this->photoService->deletePhoto($photo);
        $arrData = ['output' => 1];
        $filesystem = new Filesystem();
        $filesystem->remove([$this->getParameter('kernel.project_dir')."/public/upload/product/".$photo->getName()]);
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/photo-move-up/{id}/{photo}", name="photo_move_up", requirements={"id"="\d+", "photo"="\d+"})
     */
    public function photoMoveUp(Product $product, Photo $photo)
    {
        $this->photoService->moveUp($product, $photo->getId(), $photo->getSort());
        $arrData = ['output' => $photo->getSort()];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/photo-move-down/{id}/{photo}", name="photo_move_down", requirements={"id"="\d+", "photo"="\d+"})
     */
    public function photoMoveDown(Product $product, Photo $photo)
    {
        $this->photoService->moveDown($product, $photo->getId(), $photo->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/modification-move-up/{id}/{modification}", name="modification_move_up", requirements={"id"="\d+", "modification"="\d+"})
     */
    public function modificationMoveUp(Product $product, Modification $modification)
    {
        $this->modificationService->moveUp($product, $modification->getId(), $modification->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/modification-move-down/{id}/{modification}", name="modification_move_down", requirements={"id"="\d+", "modification"="\d+"})
     */
    public function modificationMoveDown(Product $product, Modification $modification)
    {
        $this->modificationService->moveDown($product, $modification->getId(), $modification->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/delete-mod/{id}", name="delete_mod", requirements={"id"="\d+"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deleteModification(Modification $modification)
    {
        $this->modificationService->deleteModification($modification);
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/tag-move-up/{id}/{tag}", name="tag_move_up", requirements={"id"="\d+", "tag"="\d+"})
     */
    public function tagMoveUp(Product $product, Tag $tag)
    {
        $this->tagService->moveUp($product, $tag->getId(), $tag->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/tag-move-down/{id}/{tag}", name="tag_move_down", requirements={"id"="\d+", "tag"="\d+"})
     */
    public function tagMoveDown(Product $product, Tag $tag)
    {
        $this->tagService->moveDown($product, $tag->getId(), $tag->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/choice-move-up/{id}/{choice}", name="choice_move_up", requirements={"id"="\d+", "choice"="\d+"})
     */
    public function choiceMoveUp(Product $product, Choice $choice)
    {
        $this->choiceService->moveUp($product, $choice->getId(), $choice->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/choice-move-down/{id}/{choice}", name="choice_move_down", requirements={"id"="\d+", "choice"="\d+"})
     */
    public function choiceMoveDown(Product $product, Choice $choice)
    {
        $this->choiceService->moveDown($product, $choice->getId(), $choice->getSort());
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/delete-choice/{id}", name="delete_choice", requirements={"id"="\d+"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deleteChoice(Choice $choice)
    {
        $this->choiceService->deleteChoice($choice);
        $arrData = ['output' => 1];
        return new JsonResponse($arrData);
    }
}