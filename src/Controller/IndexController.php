<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Exception\LogicException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
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
        return new RedirectResponse("/login", 301);
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $page = "app";
        $title = "Login";

        $error = $authenticationUtils->getLastAuthenticationError();
        $last_username = $authenticationUtils->getLastUsername();

        return $this->render("login/index.html.twig", [
            'error' => $error,
            'page' => $page,
            'title' => $title,
            'last_username' => $last_username
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET", "POST"})
     */
    public function logout(): void
    {
        throw new LogicException("Déconnexion");
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function adminDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return new Response("test admin");
    }

    /**
     * @Route("/dashboard", name="dashboard_index")
     */
    public function dashboard_index()
    {
        $page = "app";
        $title = "Dashboard";

        return $this->render("index.html.twig", [
            'page' => $page,
            'title' => $title,
            'user' => $this->security->getUser()
        ]);
    }

    /**
     * @Route("/signup", name="signup", methods={"GET", "POST"})
     */
    public function signup()
    {
        // TO DO
    }
}