<?php

namespace App\Controller;

use App\Entity\Zone;
use App\Form\ZoneType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $user = "1";
        $sites = "testweb";

        $zones = $this->getDoctrine()->getRepository(Zone::class)->findByUserAndSites($user, $sites);

        return $this->render("dashboard/zone/index.html.twig", [
            "page" => $page,
            "title" => $title,
            "zones" => $zones
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request) : Response
    {
        $page = "zone";
        $title = "Gestion des Zones";

        $zone = new Zone();

        $createdBy = '1';
        $siteweb = "testweb";

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $zone = $form->getData();
            $zone->setCreatedAt(new DateTime());
            $zone->setCreatedBy($createdBy);
            $zone->setSiteweb($siteweb);
  
            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();

            $this->addFlash('success', 'Création d\'une nouvelle zone correctement effectuée ! (Clic sur la croix en haut à gauche pour quitter la fenêtre)');
        }

        return $this->render("dashboard/zone/add.html.twig", [
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
        $page = "zone";
        $title = "Gestion des Zones";

        return $this->render("dashboard/zone/edit.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        $page = "zone";
        $title = "Gestion des Zones";

        return $this->render("dashboard/zone/delete.html.twig", [
            "page" => $page,
            "title" => $title
        ]);
    }
}