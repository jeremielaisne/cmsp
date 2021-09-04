<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Champ;
use App\Entity\Siteweb;
use App\Entity\Zone;

use App\Form\CategorieType;
use App\Helper\Slugify;
use DateTime;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/dashboard/categorie", name="categorie_")
*/
class CategorieController extends AbstractController
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
        $page = "categorie";
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));

        $title = "Gestion des categories";

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

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findBySites($site);

        $zones =  $this->getDoctrine()->getRepository(Zone::class)->findBySites($site);

        return $this->render("dashboard/categorie/index.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            "title" => $title,
            "user" => $this->security->getUser(),
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
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()) 
        {
            $categorie->setLibelle($request->get("libelle"));

            $slug = Slugify::index($request->get("libelle"));
            $categorie->setSlug($slug);
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
            $categorie->setCreatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return new JsonResponse(true);
        }

        return $this->render("dashboard/categorie/add.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            'title'=> $title,
            "user" => $this->security->getUser(),
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

            $slug = Slugify::index($libelle);
            $categorie->setSlug($slug);

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