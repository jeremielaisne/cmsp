<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie", name="categorie_")
*/
class CategorieController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $page = "app";
        $title= "Dashboard - Liste des categories";

        return $this->render("dashboard/categorie/index.html.twig", [
            "page" => $page, 
            'title'=> $title
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request) : Response
    {
        $page = "app";
        $title = "Dashboard - Ajout d'une categorie";

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render("dashboard/categorie/add.html.twig", [
            "page" => $page,
            'title'=> $title,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit()
    {
        $page = "app";
        $title = "Dashboard - Modification de categories";

        return $this->render("dashboard/categorie/edit.html.twig", [
            "page" => $page,
            'title'=> $title
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        $page = "app";
        $title = "Dashboard - Suppression de categories";

        return $this->render("dashboard/categorie/delete.html.twig", [
            "page" => $page,
            'title'=> $title
        ]);
    }
}