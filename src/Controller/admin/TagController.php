<?php

namespace App\Controller\admin;

use App\Entity\Tag;
use App\Form\admin\TagCreateForm;
use App\Form\admin\TagUpdateForm;
use App\Services\product\TagService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag")
 */
class TagController extends AbstractController
{
    /** @var TagService */
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @Route("/", name="view_all_tags")
     */
    public function allTags()
    {
        $tags = $this
            ->getDoctrine()
            ->getRepository(Tag::class)
            ->findAll();
        return $this->render(
            'admin/tag/index-tag.html.twig',
            [
                'tags' => $tags
            ]
        );
    }

    /**
     * @Route("/{id}", name="view_tag", requirements={"id"="\d+"})
     */
    public function viewTag(Tag $tag)
    {
        return $this->render(
            "admin/tag/viwe-one-tag.html.twig",
            [
                "tag" => $tag
            ]
        );
    }

    /**
     * @Route("/create", name="create_tag")
     */
    public function createTag(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagCreateForm::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->tagService->createTag($form->get('title')->getData());
            if ($result) {
                $this->addFlash('success', 'Метка создана!');
                return $this->redirectToRoute('view_tag',
                    array(
                        'id' => $result->getId()
                    )
                );
            }
        }

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_tag")
     */
    public function updateTag(Tag $tag, Request $request)
    {
        $form = $this->createForm(TagUpdateForm::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->updateTag($form->get('title')->getData());
            $this->addFlash('success', 'Метка обновлена!');
            return $this->redirectToRoute('view_tag',
                array(
                    'id' => $tag->getId()
                )
            );
        }

        return $this->render('admin/tag/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_tag")
     */
    public function deleteTag(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        $this->addFlash('primary', 'Метка удалена!');
        return $this->redirectToRoute('view_all_tags');
    }
}