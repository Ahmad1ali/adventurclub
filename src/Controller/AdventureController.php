<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdventureController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute("app_admin");
        }
        if($this->isGranted('ROLE_MEMBER'))
        {
            return $this->redirectToRoute("app_member");
        }
        if($this->isGranted('ROLE_DOCENT'))
        {
            return $this->redirectToRoute("app_docent");
        }
        return $this->render('adventure/index.html.twig', [
            'controller_name' => 'AdventureController',
        ]);
    }
}
