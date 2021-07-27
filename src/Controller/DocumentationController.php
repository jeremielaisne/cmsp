<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationController extends AbstractController
{
    /**
     * @Route("/document", name="dashboard_index")
     */
    public function index()
    {
        return $this->render("dashboard/document.html.twig", []);
    }
}