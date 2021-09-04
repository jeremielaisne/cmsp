<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Contenu;
use App\Entity\Siteweb;
use App\Form\ContenuType;

use DateTime;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/dashboard/contenu", name="contenu_")
*/
class ContenuController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security) 
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $page = "contenu";
        $title = "Gestion des contenus";
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));

        try {
            $site = $this->security->getUser()->getDernierSite()->getId();
        } catch (Error $e){
            $site = null;
        }

        if($request->isXmlHttpRequest()) 
        {
            $site = $request->get("site");
            $user = $this->security->getUser();
            $obj_site = $this->getDoctrine()->getRepository(Siteweb::class)->findOneBy(["nom" => $site]);
            $user->setDernierSite($obj_site);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse(true);
        }

        $contenus = [];
        $liste_contenus = $this->getDoctrine()->getRepository(Contenu::class)->findBySites($site);

        foreach($liste_contenus as $contenu){
            try{
                $contenu["type"] = unserialize($contenu["type"]);
            } catch(Error $e){
                throw $this->createNotFoundException("Erreur serialization : Page contenu (Voir types table contenu)" . $e->mb_get_info);
            }
            array_push($contenus, $contenu);
        }

        return $this->render("dashboard/contenu/index.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            "title" => $title,
            "user" => $this->security->getUser(),
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
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));

        $site = "testweb";
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
            return $this->redirectToRoute('contenu_index');
        }

        $obj_contenus = $this->getDoctrine()->getRepository(Contenu::class)->findBySiteAndCategorie($site, $categorie->getId());

        $contenus = [];
        foreach($obj_contenus as $contenu){
            try{
                $contenu["type"] = unserialize($contenu["type"]);
            } catch(Error $e){
                throw $this->createNotFoundException("Erreur serialization : Page contenu (Voir types table contenu)" . $e->mb_get_info);
            }
            array_push($contenus, $contenu);
        }

        return $this->render("dashboard/contenu/add.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            "title" => $title,
            "user" => $this->security->getUser(),
            "contenus" => $contenus,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request) : Response
    {
        $page = "contenu";
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));
        
        $title = "Gestion de contenus";
        $id = $request->get('id');

        if (empty($id))
        {
            return $this->redirectToRoute("dashboard_index");
        }

        $contenu = $this->getDoctrine()->getRepository(Contenu::class)->find($id);
        $categorie = $contenu->getCategorie();

        $form = $this->createForm(ContenuType::class, $contenu, array('categorie' => $categorie));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            return $this->redirectToRoute('contenu_index');
        }

        return $this->render("dashboard/contenu/edit.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            "title" => $title,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        $page = "contenu";
        $title = "Dashboard - Suppression de contenus";

        return $this->render("dashboard/contenu/delete.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }
}