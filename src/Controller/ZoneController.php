<?php

namespace App\Controller;

use App\Entity\Zone;

use App\Form\ZoneType;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone", name="zone_")
*/
class ZoneController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $page = "zone";
        $title = "Gestion des Zones";
        $sites = "testweb";

        $zones = $this->getDoctrine()->getRepository(Zone::class)->findBySites($sites);

        return $this->render("dashboard/zone/index.html.twig", [
            "page" => $page,
            "title" => $title,
            "zones" => $zones
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request) : Response
    {
        $page = "zone";
        $title = "Gestion des Zones";

        $zone = new Zone();

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        // En cas de soumission sans jquery
        // if($form->isSubmitted() && $form->isValid())
        // {
        //     $obj_zone = $form->getData();
        // }
        
        if($request->isXmlHttpRequest()) 
        {
            $em = $this->getDoctrine()->getManager();

            $zone->setPage($request->get("page"));
            $zone->setLibelle($request->get("libelle"));
            $zone->setUrl($request->get("url"));

            // Vérification qu'une zone n'existe pas en bdd
            $verif_zone = $em->getRepository(Zone::class)->findBy(["page" => $request->get("page"), "libelle" => $request->get("libelle")]);
            $verif_zone_url = $em->getRepository(Zone::class)->findBy(["url" => $request->get("url")]);

            if(empty($verif_zone) && empty($verif_zone_url))
            {
                $zone->setCreatedBy("1");
                $zone->setSiteweb("testweb");
                $zone->setCreatedAt(new DateTime());

                $em->persist($zone);
                $em->flush();
            } 
            else {
                if(!empty($verif_zone))
                {
                    $this->addFlash('info', 'La zone (libelle et page) existe actuellement en BDD ! Veuillez ressayer svp...');
                }
                if(!empty($verif_zone_url))
                {
                    $this->addFlash('warning', 'L\'url existe actuellement en BDD ! Veuillez ressayer avec un autre URL svp...');
                }
                return new JsonResponse(false);
            }

            return new JsonResponse(true);
        }

        return $this->render("dashboard/zone/add.html.twig", [
            "page" => $page,
            "title" => $title,
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
        $page_zone = $request->get("page");
        $url = $request->get("url");

        if($request->isXmlHttpRequest()) 
        {
            $zone = $this->getDoctrine()->getRepository(Zone::class)->find($id);
            $zone->setLibelle($libelle);
            $zone->setPage($page_zone);
            $zone->setUrl($url);
            $zone->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();

            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }

    /**
     * @Route("/delete", name="delete", methods={"GET", "POST"})
     */
    public function delete(Request $request) : Response
    {
        $id = $request->get("id");

        if($request->isXmlHttpRequest()) 
        {
            $zone = $this->getDoctrine()->getRepository(Zone::class)->find($id);
            $zone->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();

            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }
}