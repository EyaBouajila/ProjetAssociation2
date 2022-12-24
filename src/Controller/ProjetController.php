<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Worker;
use App\Form\ProjectType;
use App\Form\WorkerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    #[Route('/project/list', name: 'project.list')]
    public function listprojects(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Project::class);
        $project = $repo->findAll();
        if(!isset($project))
        {
            $this->addFlash('error',"project empty");
        }

        return $this->render('project/listProject.html.twig', [
            'listOfProjects' => $project,
        ]);
    }

    #[Route('/project/add', name: 'project.add')]
    public function addProject(ManagerRegistry $doctrine, Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($project);

            //exécution
            $entityManager->flush();

            $this->addFlash('success',"project added successfully ");
            return $this->redirectToRoute('project.list');
        }

        return $this->render('project/add-project.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>false
        ]);
    }

    #[Route('/project/update/{id?0}', name: 'project.update')]
    public function updateProject(ManagerRegistry $doctrine, Project $project = null , Request $request): Response
    {
        if (!isset($project))
        {
            return $this->redirectToRoute('project.list');
        }

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', "Project updated successfully");
            return $this->redirectToRoute('project.list');
        }

        return $this->render('project/add-project.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>true
        ]);
    }

    #[Route('/project/delete/{id?0}', name: 'project.delete')]
    public function deleteProject(ManagerRegistry $doctrine, Project $project = null) : Response
    {
        if(isset($project))
        {
            $mg = $doctrine->getManager();
            $mg->remove($project);

            $this->addFlash('success',$project->getId()." deleted successfully");
            $mg->flush();
        }
        else
        {
            $this->addFlash('error',"Project doesn't exist");
        }
        return $this->redirectToRoute('project.list');
    }

}