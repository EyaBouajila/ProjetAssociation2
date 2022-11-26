<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Form\DemandType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends AbstractController
{
    #[Route('/demand/list', name: 'demand.list')]
    public function listdemands(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Demand::class);
        $demand = $repo->findAll();
        if(!isset($demand))
        {
            $this->addFlash('error',"demand empty");
        }

        return $this->render('demand/listDemand.html.twig', [
            'listOfDemands' => $demand,
        ]);
    }

    #[Route('/demand/add', name: 'demand.add')]
    public function addDemand(ManagerRegistry $doctrine, Request $request): Response
    {
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($demand);

            $entityManager->flush();

            $this->addFlash('success',"demand added successfully ");
            return $this->redirectToRoute('demand.list');
        }

        return $this->render('demand/add-demand.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>false
        ]);
    }

    #[Route('/demand/update/{id?0}', name: 'demand.update')]
    public function updateDemand(ManagerRegistry $doctrine, Demand $demand = null , Request $request): Response
    {
        if (!isset($demand))
        {
            return $this->redirectToRoute('demand.list');
        }

        $form = $this->createForm(DemandType::class, $demand);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();

            $entityManager->persist($demand);
            $entityManager->flush();

            $this->addFlash('success', "Demand updated successfully");
            return $this->redirectToRoute('demand.list');
        }

        return $this->render('demand/add-demand.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>true
        ]);
    }

    #[Route('/demand/delete/{id?0}', name: 'demand.delete')]
    public function deleteDemand(ManagerRegistry $doctrine, Demand $demand = null) : Response
    {
        if(isset($demand))
        {
            $mg = $doctrine->getManager();
            $mg->remove($demand);

            $this->addFlash('success',$demand->getId()." deleted successfully");
            $mg->flush();
        }
        else
        {
            $this->addFlash('error',"Demand doesn't exist");
        }
        return $this->redirectToRoute('demand.list');
    }
}