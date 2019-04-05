<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/admin", name="main_page")
     */
    public function mainPage()
    {
        return $this->render('admin/main-page.html.twig');
    }
}