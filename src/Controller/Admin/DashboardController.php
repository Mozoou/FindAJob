<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Candidat;
use App\Controller\Admin\UserCrudController;
use App\Entity\Companies;
use App\Entity\ExpPro;
use App\Entity\Formations;
use App\Entity\SchoolDegree;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FindAJob');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-user-graduate', Candidat::class);
        yield MenuItem::linkToCrud('Companies', 'fas fa-building', Companies::class);
        yield MenuItem::linkToCrud('Formations', 'fas fa-graduation-cap', Formations::class);
        yield MenuItem::linkToCrud('Experience Pro', 'fa-brands fa-connectdevelop', ExpPro::class);
        yield MenuItem::linkToCrud('Niveau études', 'fas fa-school-flag', SchoolDegree::class);


    }
}
