<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Contenu;
use App\Form\ContenuType;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $page = "contenu";
        $title = "Gestion des contenus";
        $sites = "testweb";

        $contenus = $this->getDoctrine()->getRepository(Contenu::class)->findBySites($sites);

        return $this->render("dashboard/contenu/index.html.twig", [
            "page" => $page,
            "title" => $title,
            "contenus" => $contenus
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request) : Response
    {
        $page = "contenu";
        $title = "Gestion de contenus";
        $id = $request->get('id');

        if (empty($id))
        {
            return $this->redirectToRoute("dashboard_index");
        }

        $contenu = new Contenu();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $form = $this->createForm(ContenuType::class, $contenu, array('categorie' => $categorie));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contenu = $form->getData();

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