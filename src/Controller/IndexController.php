<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard_index")
     */
    public function index()
    {
        return $this->render("index.html.twig", []);
    }
}