<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidat;
use App\Entity\Companies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MatchingController extends AbstractController
{
    private $security;

    private $parameterBag;

    public function __construct(Security $security, ParameterBagInterface $parameterBag)
    {
        $this->security = $security;
        $this->parameterBag = $parameterBag;
    }

    #[Route('/matching', name: 'app_matching')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        if ($user == null) {
            $this->addFlash('danger', 'Veuillez vous connecter avant de pouvoir faire un matching');
            return $this->redirectToRoute('app_login');
        }
        // ROLE_CANDIDAT Matching
        if (in_array('ROLE_CANDIDAT', $user->getRoles())) {
            // recuperation des infos du candidat
            $myProfil = $user->getCandidat();
            $domaine = $myProfil->getFormations();
            $region = $myProfil->getSearchedRegion();
            $resultProfiles = $entityManager->getRepository(Companies::class)->findByCriteria($domaine, $region);
        } /* ROLE_COMPANY Matching */ elseif (in_array('ROLE_COMPANY', $user->getRoles())) {
            $myProfil = $entityManager->getRepository(Companies::class)->findOneById($user->getCompanies()->getId());
            $domaines = $myProfil->getSearchingFor();
            $region = $myProfil->getSearchedRegion();
            $resultProfiles = $entityManager->getRepository(Candidat::class)->findByCriteria($domaines, $region);
            // dd($resultProfiles);
        } else {
            $this->addFlash('danger', 'Seul les candidats ou les companies on accès au matching !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('matching/matching.html.twig', [
            'myProfil' => $myProfil,
            'ResultProfiles' => $resultProfiles
        ]);
    }
}
