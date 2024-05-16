<?php

namespace App\Controller;

use App\Entity\Story;
use App\Form\UpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function admin(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $showStory = $em->getRepository(Story::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'storys' => $showStory,
            'user'=>$user
        ]);
    }
    #[Route('/update/{id}', name: 'app_update')]
    public function Update(EntityManagerInterface $em ,int $id ,Request $request): Response
    {
        $user = $this->getUser();

        $showStory = $em->getRepository(Story::class)->find($id);
        $form = $this->createForm(UpdateType::class, $showStory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/update.html.twig', [
            'storys' => $showStory,
            'user'=>$user,
            'form'=>$form

        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $em ,int $id ,Request $request): Response
    {
        $deleteStory = $em->getRepository(Story::class);
        $story = $deleteStory->find($id);
        $em->remove($story);
        $em->flush();
        return $this->redirectToRoute('app_admin');
    }

}
