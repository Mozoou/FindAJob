<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\User;
use App\Form\CompaniesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
        return $this->render('companies/index.html.twig');
    }

    #[Route('/companies/add', name: 'app_new_company')]
    public function add(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        if($user->getCompanies() !== null){
            // TODO : voir si on redirige vers la home page ou une autre page
            return $this->redirectToRoute('app_home');
        }
        $companies = new Companies();
        $form = $this->createForm(CompaniesType::class, $companies);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($user)
            $companies->addUser($user);
            $companies->setName($form->get('name')->getData());
            $companies->setPhone($form->get('phone')->getData());
            $companies->setFax($form->get('fax')->getData());
            $CompanyLogo = $form->get('logo')->getData();
            //image
            if ($CompanyLogo) {
                $originalFilename = pathinfo($CompanyLogo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $CompanyLogo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $CompanyLogo->move(
                        $this->getParameter('img_directory_companies'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ProfilePictureFile' property to store the PDF file name
                // instead of its contents
                $companies->setLogo($newFilename);
            }
            $companies->setIsSearching($form->get('is_searching')->getData());
            $companies->setSearchingFor($form->get('searching_for')->getData());
            $companies->setSearchedRegion($form->get('searched_region')->getData());
            $siret = $form->get('siret')->getData();
            $siren = $this->nSIREN($siret);
            $tva = $this->nTVA($siren);
            $companies->setSiret($siret);
            $companies->setSiren($siren);
            $companies->setTva($tva);
            $entityManager->persist($companies);
            $entityManager->flush();
            $this->addFlash('success', 'Vos informations on bien été enregistrer');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('companies/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/companies/edit', name: 'app_edit_company')]
    public function edit(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        if($user->getCompanies()->getId() !== null){
            $companies = $entityManager->getRepository(Companies::class)->findOneById($user->getCompanies()->getId());
        } else {
            $companies = new Companies();
        }
        $form = $this->createForm(CompaniesType::class, $companies);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($user)
            $companies->addUser($user);
            $companies->setName($form->get('name')->getData());
            $companies->setPhone($form->get('phone')->getData());
            $companies->setFax($form->get('fax')->getData());
            $CompanyLogo = $form->get('logo')->getData();
            //image
            if ($CompanyLogo) {
                $originalFilename = pathinfo($CompanyLogo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $CompanyLogo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $CompanyLogo->move(
                        $this->getParameter('img_directory_companies'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ProfilePictureFile' property to store the PDF file name
                // instead of its contents
                $companies->setLogo($newFilename);
            }
            $companies->setIsSearching($form->get('is_searching')->getData());
            $companies->setSearchingFor($form->get('searching_for')->getData());
            $companies->setSearchedRegion($form->get('searched_region')->getData());
            $siret = $form->get('siret')->getData();
            $siren = $this->nSIREN($siret);
            $tva = $this->nTVA($siren);
            $companies->setSiret($siret);
            $companies->setSiren($siren);
            $companies->setTva($tva);
            $entityManager->persist($companies);
            $entityManager->flush();
            $this->addFlash('success', 'Vos informations on bien été enregistrer');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('companies/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/companies/{id}', name: 'app_view_company')]
    public function view(int $id, EntityManagerInterface $entityManager){
        $company = $entityManager->getRepository(Companies::class)->findOneById($id);
        return $this->render('companies/view.html.twig', [
            'company' => $company
        ]);
    }

    public function nSIREN($siret)
    {
        return substr($siret, 0, 9);
    }
    public function nTVA($siren)
    {
        return "FR" . ((12 + 3 * ($siren % 97)) % 97) . $siren;
    }
}
