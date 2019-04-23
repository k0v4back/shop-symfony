<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    /**
     * @Route("/basket", name="main_basket_page")
     */
    public function mainPage()
    {
        return $this->render('basket.html.twig');
    }
}