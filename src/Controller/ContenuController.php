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
        $page = "app";
        $title = "Dashboard - Liste de contenus";

        return $this->render("dashboard/contenu/index.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request) : Response
    {
        $page = "app";
        $title = "Dashboard - Ajout de contenus";

        $contenu = new Contenu();

        $form = $this->createForm(ContenuType::class, $contenu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();

            return $this->redirectToRoute('contenu_index');
        }

        return $this->render("dashboard/contenu/add.html.twig", [
            "page" => $page,
            "title" => $title,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit()
    {
        $page = "app";
        $title = "Dashboard - Modification de contenus";

        return $this->render("dashboard/contenu/edit.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        $page = "app";
        $title = "Dashboard - Suppression de contenus";

        return $this->render("dashboard/contenu/delete.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }
}