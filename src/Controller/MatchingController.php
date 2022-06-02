<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    #[Route('/matching', name: 'app_matching')]
    public function index(): Response
    {
        // Seul les users avec le role candidat pourront accéder à cette page
        // On récupère les infos du candidat et on fait une recherche parmi les offres des candidats
        return $this->render('matching/index.html.twig');
    }
}
