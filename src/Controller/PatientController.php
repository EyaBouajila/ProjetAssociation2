<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient/list', name: 'patient.list')]
    public function listpatients(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Patient::class);
        $patient = $repo->findAll();
        if(!isset($patient))
        {
            $this->addFlash('error',"patient empty");
        }

        return $this->render('patient/listPatient.html.twig', [
            'listOfPatients' => $patient,
        ]);
    }

    #[Route('/patient/add', name: 'patient.add')]
    public function addPatient(ManagerRegistry $doctrine, Request $request): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($patient); //objet (['name','lastName', ...])

            $entityManager->flush();

            $this->addFlash('success',"patient added successfully ");
            return $this->redirectToRoute('patient.list');
        }

        return $this->render('patient/add-patient.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>false
        ]);
    }

    #[Route('/patient/update/{id?0}', name: 'patient.update')]
    public function updatePatient(ManagerRegistry $doctrine, Patient $patient = null , Request $request): Response
    {
        if (!isset($patient))
        {
            return $this->redirectToRoute('patient.list');
        }

        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            $this->addFlash('success', "Patient updated successfully");
            return $this->redirectToRoute('patient.list');
        }

        return $this->render('patient/add-patient.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>true
        ]);
    }

    #[Route('/patient/delete/{id?0}', name: 'patient.delete')]
    public function deletePatient(ManagerRegistry $doctrine, Patient $patient = null) : Response
    {
        if(isset($patient))
        {
            $mg = $doctrine->getManager();
            $mg->remove($patient);

            $this->addFlash('success',$patient->getId()." deleted successfully");
            $mg->flush();
        }
        else
        {
            $this->addFlash('error',"Patient doesn't exist");
        }
        return $this->redirectToRoute('patient.list');
    }
}