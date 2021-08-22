<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Champ;
use App\Entity\Zone;

use App\Form\CategorieType;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $page = "categorie";
        $title= "Gestion des categories";

        $user = "1";
        $sites = "testweb";

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findByUserAndSites($user, $sites);

        $zones =  $this->getDoctrine()->getRepository(Zone::class)->findByUserAndSites($user, $sites);

        return $this->render("dashboard/categorie/index.html.twig", [
            "page" => $page, 
            "title" => $title,
            "categories" => $categories,
            "zones" => $zones
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request) : Response
    {
        $page = "categorie";
        $title = "Dashboard - Ajout d'une categorie";

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()) 
        {
            $categorie->setLibelle($request->get("libelle"));
            $categorie->setDescription($request->get("description"));
            
            $champs = $request->get("champ");
            if (!empty($champs)){
                foreach($champs as $champ) {
                    $obj_champ =  $this->getDoctrine()->getRepository(Champ::class)->find($champ);
                    $categorie->addChamps($obj_champ);
                }
            } else {
                return new JsonResponse(false);
            }
            $zone = $request->get("zone");
            $obj_zone = $this->getDoctrine()->getRepository(Zone::class)->find($zone);
            $categorie->setZone($obj_zone);

            $categorie->setCreatedBy("1");
            $categorie->setSiteweb("testweb");
            $categorie->setCreatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return new JsonResponse(true);
        }

        return $this->render("dashboard/categorie/add.html.twig", [
            "page" => $page,
            'title'=> $title,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request) : Response
    {
        $id = $request->get("id");
        $libelle = $request->get("libelle");
        $description = $request->get("description");
        $zone = $request->get("zone");

        if($request->isXmlHttpRequest()) 
        {
            $obj_zone = $this->getDoctrine()->getRepository(Zone::class)->find($zone);
            $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
            $categorie->setLibelle($libelle);
            $categorie->setDescription($description);
            $categorie->setZone($obj_zone);
            $categorie->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return new JsonResponse(true);
        }
    }

    /**
     * @Route("/delete",  name="delete", methods={"GET", "POST"})
     */
    public function delete(Request $request)
    {
        $id = $request->get("id");

        if($request->isXmlHttpRequest()) 
        {
            $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
            $categorie->setIsActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }
}