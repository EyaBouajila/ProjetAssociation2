<?php

namespace App\Controller;


use App\Entity\Worker;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkerController extends AbstractController
{
    #[Route('/worker/list', name: 'worker.list')]
    public function listworkers(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Worker::class); //bech ni5dem bel les methodes sous workerrepository
        $worker = $repo->findAll(); // k => v
        if(!isset($worker)) // array empty
        {
            $this->addFlash('error',"worker empty");
            //return $this->redirectToRoute('worker.list');
        }

        return $this->render('worker/listWorker.html.twig', [
            'listOfWorkers' => $worker,
        ]);// [id,name,ln,..]
    }

}
