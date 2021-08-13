<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slider", name="slider_")
*/
class SliderController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $page = "app";
        $title = "Dashboard - Liste des sliders";
        
        return $this->render("dashboard/slider/index.html.twig", ["page" => $page, "title" => $title]);
    }
}