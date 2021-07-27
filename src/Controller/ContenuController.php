<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contenu", name="contenu_")
*/
class ContenuController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $page = "Dashboard - Contenu";
        return $this->render("dashboard/contenu.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorie()
    {
        $page = "Dashboard - Catégorie";
        return $this->render("dashboard/categorie.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/zone", name="zone")
     */
    public function zone()
    {
        $page = "Dashboard - Zone";
        return $this->render("dashboard/zone.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/slider", name="slider")
     */
    public function slider()
    {
        $page = "Dashboard - Sliders";
        return $this->render("dashboard/slider.html.twig", ["page" => $page]);
    }
}