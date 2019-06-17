<?php

namespace App\Controller;

use App\Entity\PostalCode;
use App\Repository\PostalCodeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * Permet d'afficher la page de connexion à l'application web
     * 
     * @Route("/", name="homepage")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $userName = $utils->getLastUsername();
        $classHeader = NULL;

        return $this->render('home/login.html.twig', [
            'hasError' => $error !== null,
            'userName' => $userName,
            'classHeader' => $classHeader
        ]);
    }

    /**
     * Permet de gérer la déconnexion
     * 
     * @Route("/logout", name="user_logout")
     *
     * @return void
     */
    public function logout() {
        // .. nothing to do
        // .. Symfony will do it !
    }

}
