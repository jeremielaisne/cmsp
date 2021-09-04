<?php

namespace App\Controller;

use App\Entity\Siteweb;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/dashboard/user", name="user_")
*/
class UserController extends AbstractController
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
    public function index()
    {
        $page = "user";

        return $this->render("user/index.html.twig", ["page" => $page]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request)
    {
        $page = "user";
        $title = "Profil";
        $routeName = $request->getPathInfo();
        $breadcrumb = array_filter(explode("/", $routeName));

        try {
            $site = $this->security->getUser()->getDernierSite()->getId();
        } catch (Error $e){
            $site = null;
        }

        $user = $this->security->getUser();

        if($request->isXmlHttpRequest()) 
        {
            $site = $request->get("site");
            
            $obj_site = $this->getDoctrine()->getRepository(Siteweb::class)->findOneBy(["nom" => $site]);
            $user->setDernierSite($obj_site);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse(true);
        }

        return $this->render("user/profil.html.twig", [
            "page" => $page,
            "breadcrumb" => $breadcrumb,
            "title" => $title,
            "user" => $this->security->getUser()
        ]);
    }
}