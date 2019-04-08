<?php

namespace App\Twig;

use App\Entity\User;
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

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }
    public function getFilters()
    {
        return [
            new TwigFilter('statusText', [$this, 'statusText']),
            new TwigFilter('statusClass', [$this, 'statusClass']),
            new TwigFilter('treeCategories', [$this, 'treeCategories'])
        ];
    }

    public function listStatus()
    {
        return [
            User::IS_ACTIVE => 'Активен',
            User::IS_WAITING => 'Ожидает'
        ];
    }

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

    public function treeCategories($tree)
    {
            $indent = ($tree->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
            return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
    }
}