<?php

namespace App\Controller;

use App\Entity\Funder;
use App\Entity\Worker;
use App\Form\FunderType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FunderController extends AbstractController
{
    #[Route('/funder/list', name: 'funder.list')]
    public function listfunders(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Funder::class); //bech ni5dem bel les methodes sous funderrepository
        $funder = $repo->findAll(); // k => v
        if(!isset($funder)) // array empty
        {
            $this->addFlash('error',"funder empty");
            //return $this->redirectToRoute('funder.list');
        }

        return $this->render('funder/listFunder.html.twig', [
            'listOfFunders' => $funder,
        ]);
    }

    #[Route('/funder/add', name: 'funder.add')]
    public function addFunder(ManagerRegistry $doctrine, Request $request): Response
    {
        $funder = new Funder(); //objet vide temporairement
        //l'image de notre formulaire
        //classType (form) | object (entity)
        $form = $this->createForm(FunderType::class, $funder);

        $form->handleRequest($request); //form now know it's a post request

        if($form->isSubmitted()) //clicked on submit (methode post)
        {
            $entityManager = $doctrine->getManager();
            //$form->getData(); return array of data
            //WorkerType : name -> object (worker : attribut : name) => mapping
            $entityManager->persist($funder); //objet (['name','lastName', ...])

            //exécution
            $entityManager->flush();

            $this->addFlash('success',"funder added successfully ");
            return $this->redirectToRoute('funder.list');
        }

        return $this->render('funder/add-funder.html.twig',[
            //passer la form au formulaire
            'f'=>$form->createView(),
            'isEdit'=>false
        ]);
    }

    #[Route('/funder/update/{id?0}', name: 'funder.update')]
    public function updateFunder(ManagerRegistry $doctrine, Funder $funder = null , Request $request): Response
    {
        //si la personne (id ==0) est null
        if (!isset($funder))
        {
            return $this->redirectToRoute('funder.list');
        }

        $form = $this->createForm(FunderType::class, $funder);

        $form->handleRequest($request); //form now know it's a post request

        if ($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            //$form->getData(); return array of data

            $entityManager->persist($funder);
            $entityManager->flush();

            $this->addFlash('success', "Funder updated successfully");
            return $this->redirectToRoute('funder.list');
        }

        return $this->render('funder/add-funder.html.twig',[
            //passer la form au formulaire
            'f'=>$form->createView(),
            'isEdit'=>true
        ]);
    }

    #[Route('/funder/delete/{id?0}', name: 'funder.delete')]
    public function deleteFunder(ManagerRegistry $doctrine, Funder $funder = null) : Response
    {
        if(isset($funder))
        {
            $mg = $doctrine->getManager();
            $mg->remove($funder);

            $this->addFlash('success',$funder->getName()." deleted successfully");
            //exécution
            $mg->flush();
        }
        else
        {
            $this->addFlash('error',"Funder doesn't exist");
        }
        return $this->redirectToRoute('funder.list');
    }

}