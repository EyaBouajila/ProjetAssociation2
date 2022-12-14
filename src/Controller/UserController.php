<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user'), IsGranted("ROLE_ADMIN")]
class UserController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    #[Route('/worker/list', name: 'worker.list')]
    public function listworkers(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(User::class); //bech ni5dem bel les methodes sous workerrepository
        $worker = $repo->findAll(); // k => v
        if(!isset($worker)) // array empty
        {
            $this->addFlash('error',"worker empty");
            //return $this->redirectToRoute('worker.list');
        }

        return $this->render('user/show.html.twig', [
            'listOfWorkers' => $worker,
        ]);// [id,name,ln,..]
    }

    #[Route('/worker/add', name: 'worker.add')]
    public function addWorker(ManagerRegistry $doctrine, Request $request): Response
    {
        $worker = new User(); //objet vide temporairement
        //l'image de notre formulaire
        //classType (form) | object (entity)
        $form = $this->createForm(UserType::class, $worker);

        $form->handleRequest($request); //form now know it's a post request

        if($form->isSubmitted()) //clicked on submit (methode post)
        {
            $entityManager = $doctrine->getManager();
            $worker->setPassword($this->hasher->hashPassword($worker,$worker->getPassword()));
            //$form->getData(); return array of data
            //WorkerType : name -> object (worker : attribut : name) => mapping
            $entityManager->persist($worker); //objet (['name','lastName', ...])

            //ex??cution
            $entityManager->flush();

            $this->addFlash('success',"worker added successfully ");
            return $this->redirectToRoute('worker.list');
        }

        return $this->render('user/new.html.twig',[
            //passer la form au formulaire
            'f'=>$form->createView(),
            'isEdit'=>false
        ]);
    }

    #[Route('/worker/update/{id?0}', name: 'worker.update')]
    public function updateWorker(ManagerRegistry $doctrine, User $worker = null , Request $request): Response
    {
        //si la personne (id == 0) est null
        if (!isset($worker))
        {
            return $this->redirectToRoute('worker.list');
        }

        $form = $this->createForm(UserType::class, $worker);

        $form->handleRequest($request); //form now know it's a post request

        if ($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            //$form->getData(); return array of data
            $worker->setPassword($this->hasher->hashPassword($worker,$worker->getPassword()));


            $entityManager->persist($worker);
            $entityManager->flush();

            $this->addFlash('success', "Worker updated successfully");
            return $this->redirectToRoute('worker.list');
        }

        return $this->render('user/new.html.twig',[
            //passer la form au formulaire
            'f'=>$form->createView(),
            'isEdit'=>true
        ]);
    }

    #[Route('/worker/delete/{id?0}', name: 'worker.delete')]
    public function deleteWorker(ManagerRegistry $doctrine, User $worker = null) : Response
    {
        if(isset($worker))
        {
            $mg = $doctrine->getManager();
            $mg->remove($worker);

            $this->addFlash('success',$worker->getFirstName()." deleted successfully");
            //ex??cution
            $mg->flush();
        }
        else
        {
            $this->addFlash('error',"Worker doesn't exist");
        }
        return $this->redirectToRoute('worker.list');
    }

}
