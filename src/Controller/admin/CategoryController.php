<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\admin\CategoryForm;
use App\Services\product\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class CategoryController extends AbstractController
{
    /** @var CategoryService */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/category/create", name="create_category")
     */
    public function createCategory(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setTitle($form->get('title')->getData());
            $em = $this->getDoctrine()->getManager();

            if ($form->get('parent')->getData() != null) {
                $en = $em->getRepository(Category::class)->findOneBy([
                    'title' => $form->get('parent')->getData()
                ]);
                if ($this->categoryService->createCategory($form->get('title')->getData(), $en) != null) {
//                    $this->addFlash('success', 'Категория добавлена');
//
//                    return $this->redirectToRoute('view_user',
//                        array(
//                            'id' => $category->getId()
//                        )
//                    );
                }

            } else {
                $this->categoryService->createCategory($form->get('title')->getData());
            }

        }
        return $this->render('admin/category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}