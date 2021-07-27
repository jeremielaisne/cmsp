<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $page = "Liste des utilisateurs";
        return $this->render("user/index.html.twig", ["page" => $page]);
    }
}