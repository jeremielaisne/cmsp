<?php

namespace App\Controller;

use App\Entity\Contenu;
use App\Form\ContenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $page = "Dashboard - Liste de contenus";
        return $this->render("dashboard/contenu.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/add-contenu", name="add_contenu")
     */
    public function add_contenu(Request $request) : Response
    {
        $page = "Dashboard - Ajout de contenus";

        $contenu = new Contenu();

        $form = $this->createForm(ContenuType::class, $contenu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();

            return $this->redirectToRoute('contenu_index');
        }

        return $this->render("dashboard/add-contenu.html.twig", [
            "page" => $page,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-contenu", name="edit_contenu")
     */
    public function edit_contenu()
    {
        $page = "Dashboard - Modification de contenus";
        return $this->render("dashboard/edit-contenu.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/delete-contenu", name="delete_contenu")
     */
    public function delete_contenu()
    {
        $page = "Dashboard - Suppression de contenus";
        return $this->render("dashboard/delete-contenu.html.twig", ["page" => $page]);
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