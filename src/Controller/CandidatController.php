<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CandidatController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/candidat', name: 'app_candidat')]
    public function index(): Response
    {
        return $this->render('candidat/index.html.twig');
    }
    
    #[Route('/candidat/new', name: 'app_new_candidat')]
    public function newCandidat(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = $this->security->getUser();
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $candidat->setUser($user);
            $candidat->setFirstname($form->get('firstname')->getData());
            $candidat->setFirstname($form->get('lastname')->getData());
            $ProfilePictureFile = $form->get('profile_picture')->getData();
            // this condition is needed because the 'profile_picture' field is not required
            if ($ProfilePictureFile) {
                $originalFilename = pathinfo($ProfilePictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$ProfilePictureFile->guessExtension();
                
                // Move the file to the directory where brochures are stored
                try {
                    $ProfilePictureFile->move(
                        $this->getParameter('pp_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'ProfilePictureFile' property to store the PDF file name
                // instead of its contents
                $candidat->setProfilePicture($newFilename);
            }
            $candidat->setDateBirth($form->get('date_birth')->getData());
            $candidat->setIsSearching($form->get('is_searching')->getData());
            $candidat->setHardSkills($form->get('hard_skills')->getData());
            $candidat->setSoftSkills($form->get('soft_skills')->getData());
            $candidat->setFormations($form->get('formations')->getData());
            $candidat->setStudiesLevel($form->get('studies_level')->getData());
            $candidat->setProExp($form->get('pro_exp')->getData());
            $candidat->setLinkdin('linkedin.com/in/'.$form->get('linkdin')->getData());
            $candidat->setSearchedRegion($form->get('searched_region')->getData());
            $entityManager->persist($candidat);
            $entityManager->flush();
            $this->addFlash('success', 'Vos informations on bien été enregistrer');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('candidat/candidatForm.html.twig', [
            'CandidatForm' => $form->createView(),
        ]);
    }
}
