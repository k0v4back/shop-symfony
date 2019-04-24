<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\AllTagsRepository;
use App\Repository\ChoiceRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TagRepository */
    private $tagRepository;

    /** @var AllTagsRepository */
    private $allTagsRepository;

    /** @var ChoiceRepository */
    private $choiceRepository;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        TagRepository $tagRepository,
        AllTagsRepository $allTagsRepository,
        ChoiceRepository $choiceRepository,
        ProductRepository $productRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
        $this->allTagsRepository = $allTagsRepository;
        $this->choiceRepository = $choiceRepository;
        $this->productRepository = $productRepository;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('statusText', [$this, 'statusText']),
            new TwigFilter('statusClass', [$this, 'statusClass']),
            new TwigFilter('getTag', [$this, 'getTag']),
            new TwigFilter('userTextRole', [$this, 'userTextRole']),
            new TwigFilter('roleClass', [$this, 'roleClass']),
            new TwigFilter('srtRepeat', [$this, 'srtRepeat']),
            new TwigFilter('minPrice', [$this, 'minPrice']),
            new TwigFilter('maxPrice', [$this, 'maxPrice']),
            new TwigFilter('price', [$this, 'price']),
            new TwigFilter('getProduct', [$this, 'getProduct'])
        ];
    }

    public function listStatus()
    {
        return [
            User::IS_ACTIVE => 'Активен',
            User::IS_WAITING => 'Ожидает'
        ];
    }

    /*
     * Get user status
     */
    public function statusClass($status_id)
    {
        switch ($status_id) {
            case User::IS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case User::IS_WAITING:
                $class = 'badge badge-secondary';
                break;
            default:
                $class = 'badge badge-dark';
        }

        return $class;
    }

    public function statusText($status_id)
    {
        switch ($status_id) {
            case User::IS_ACTIVE:
                $text = 'Активен';
                break;
            case User::IS_WAITING:
                $text = 'Ожидает';
                break;
            default:
                $text = 'хз';
        }
        return $text;
    }


    /*
     * Get tag
     */
    public function getTag($tagId)
    {
        $resultTag = $this->allTagsRepository->findOneBy([
            'id' => $tagId
        ]);

        if ($resultTag) {
            return $resultTag->getTitle();
        } else return null;
    }


    /*
     * User role badge
     */
    public function userTextRole($role)
    {
        switch ($role[0]) {
            case User::ROLE_USER:
                $textRole = 'Покупатель';
                break;
            case User::ROLE_ADMIN:
                $textRole = 'Администратор';
                break;
            case User::ROLE_SUPER_ADMIN:
                $textRole = 'Супер администратор';
                break;
            default:
                $textRole = 'Левый тип';
        }
        return $textRole;
    }

    public function roleClass($role)
    {
        switch ($role[0]) {
            case User::ROLE_USER:
                $class = 'badge badge-secondary';
                break;
            case User::ROLE_ADMIN:
                $class = 'badge badge-warning';
                break;
            case User::ROLE_SUPER_ADMIN:
                $class = 'badge badge-danger';
                break;
            default:
                $class = 'badge badge-dark';
        }
        return $class;
    }

    public function srtRepeat($count)
    {
        return str_repeat('--', $count);
    }

    public function minPrice($productId)
    {
        $minPrice = $this->choiceRepository->findOneBy(['product' => $productId], ['sort' => 'ASC']);

        return $minPrice->getPrice();
    }

    public function maxPrice($productId)
    {
        $maxPrice = $this->choiceRepository->findOneBy(['product' => $productId], ['sort' => 'DESC']);

        return $maxPrice->getPrice();
    }

    public function price($productId)
    {
        $maxPrice = $this->choiceRepository->findOneBy(['product' => $productId]);

        return $maxPrice->getPrice();
    }


    public function getProduct($productId)
    {
        $product = $this->productRepository->findOneBy(['id' => $productId]);

        return $product;
    }
}