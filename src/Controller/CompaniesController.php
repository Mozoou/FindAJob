<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompaniesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompaniesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    #[Route('/companies', name: 'app_companies')]
    public function index(): Response
    {
        return $this->render('companies/index.html.twig', [
            'form'
        ]);
    }

    #[Route('/companies/add', name: 'app_new_company')]
    public function add(Request $request): Response
    {
        $user = $this->security->getUser();
        $companies = new Companies();
        $form = $this->createForm(CompaniesType::class, $companies);
        $form->handleRequest($request);

        return $this->render('companies/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
