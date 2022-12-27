<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Entity\DemandFundingPatient;
use App\Entity\DemandFundingProject;
use App\Entity\Patient;
use App\Form\DemandType;
use App\Service\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DemandController extends AbstractController
{
    public function __construct(private Security $security)
    {
    }

    #[Route('/demand/updateStatus/{id?0}', name: 'demand.update.status')]
    public function updateDemandStatus(ManagerRegistry $doctrine ,
                                       Request $request,
                                       int $id,
                                       MailerService $mailerService): Response
    {
        $repo = $doctrine->getRepository(Demand::class);
        $demand = $repo->find($id);
        $arrayRoles = $this->security->getUser()->getRoles();

        $reqValue = $request->get('value');

        foreach ($arrayRoles as $k => $v){
            if($v == 'ROLE_ADMIN'){
                if($reqValue == 'accept'){
                    $demand->setState("acceptedAdmin");
                }
                if($reqValue == 'refuse'){
                    $demand->setState("refusedAdmin");
                }
                if($reqValue == 'ceo'){
                    $demand->setState("acceptedToCEO");
                }
            }
            if($v == 'ROLE_CEO'){
                if($reqValue == 'acceptToSG'){
                    $demand->setState("acceptedToSG");
                }
                if($reqValue == 'refuse'){
                    $demand->setState("refusedCEO");
                }
            }
            if($v == 'ROLE_SG'){
                if($reqValue == 'accept'){
                    $demand->setState("acceptedSG");
                }
                if($reqValue == 'refuse'){
                    $demand->setState("refusedSG");
                }
            }
            $entityManager = $doctrine->getManager();

            $entityManager->persist($demand);
            $entityManager->flush();

            if($reqValue == 'accept'){

                if(!$demand->getTargetPatient()->isEmpty()){
                    $x = 0;
                    $totalTarget = $demand->getTargetPatient()->count();
                    while($x < $totalTarget) {
                        $demandFundPatient = new DemandFundingPatient();
                        $demandFundPatient->setDemand($demand);
                        $demandFundPatient->setPatient($demand->getTargetPatient()->get($x));
                        $demandFundPatient->setFund($demand->getFundingRecieved() / $totalTarget);
                        $entityManager->persist($demandFundPatient);
                        $x++;
                    }
                }

                if(!$demand->getTargetProject()->isEmpty()){
                    $x = 0;
                    $totalTarget = $demand->getTargetProject()->count();
                    while($x < $totalTarget) {
                        $demandFundProject = new DemandFundingProject();
                        $demandFundProject->setDemand($demand);
                        $demandFundProject->setProject($demand->getTargetProject()->get($x));
                        $demandFundProject->setFund($demand->getFundingRecieved() / $totalTarget);
                        $entityManager->persist($demandFundProject);
                        $x++;
                    }
                }

                $entityManager->flush();

                $mailerContent  = '<h2> Your demand has been accepted successfully at : '
                    . $demand->getUpdatedAt()->format('d-m-Y'). '</h2>';
                $email  = $demand->getActivityFunder()->getEmail();
                $from = 'testing.symfony123@gmail.com';

                $mailerService->sendEmail(from :$from ,content: $mailerContent, to: $email, subject: 'Demand Added');
            }

            $this->addFlash('success', "Demand updated successfully");
        }

        return $this->redirectToRoute('demand.list');
    }

    #[Route('/demand/list', name: 'demand.list')]
    public function listdemands(ManagerRegistry $doctrine, Request $request): Response
    {
        $arrayRoles = $this->security->getUser()->getRoles();
        $repo = $doctrine->getRepository(Demand::class);
        $demand = new Demand();
        $keyword = $request->get("keyword");

        foreach ($arrayRoles as $k => $v){
            if($v == "ROLE_ADMIN" || $v == "ROLE_WORKER"){
                $demand = $repo->findByStatus("review" , $keyword);
            }
            if($v == "ROLE_CEO"){
                $demand = $repo->findByStatus("acceptedToCEO",$keyword);
            }
            if($v == "ROLE_SG"){
                $demand = $repo->findByStatus("acceptedToSG",$keyword);
            }
            if(!isset($demand))
            {
                $this->addFlash('error',"demand empty");
            }
        }

        return $this->render('demand/listDemand.html.twig', [
            'listOfDemands' => $demand,
        ]);
    }

    #[Route('/demand/history', name: 'demand.history')]
    public function historydemands(ManagerRegistry $doctrine): Response
    {
        $arrayRoles = $this->security->getUser()->getRoles();
        $repo = $doctrine->getRepository(Demand::class);
        $demand = new Demand();
        foreach ($arrayRoles as $k => $v){
            if($v == "ROLE_ADMIN"){
                $demand = $repo->findByStatus3( "acceptedAdmin","refusedAdmin","acceptedToCEO");
            }
            if($v == "ROLE_CEO"){
                $demand = $repo->findByStatus2("acceptedToSG","refusedCEO");
            }
            if($v == "ROLE_SG"){
                $demand = $repo->findByStatus2("acceptedSG","refusedSG");
            }
            if(!isset($demand))
            {
                $this->addFlash('error',"demand empty");
            }
        }

        return $this->render('demand/listDemandHistory.html.twig', [
            'listOfDemands' => $demand,
        ]);
    }

    #[Route('/demand/add', name: 'demand.add')]
    public function addDemand(ManagerRegistry $doctrine, Request $request, MailerService $mailerService): Response
    {
        $this->denyAccessUnlessGranted("ROLE_WORKER");
        $reqValue = $request->get('value');
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            //set the current user (worker)
            $demand->setWorkerInv($this->security->getUser());
            $demand->setState("review");

            $demand->getActivityFunder()->setNbrActivities($demand->getActivityFunder()->getNbrActivities()+1);

            $entityManager->persist($demand);
            $entityManager->flush();

            $mailerContent  = '<h2> Your demand has been added successfully at : '
                . $demand->getCreatedAt()->format('d-m-Y'). '</h2>';
            $email  = $demand->getActivityFunder()->getEmail();
            $from = 'testing.symfony123@gmail.com';

            $mailerService->sendEmail(from :$from ,content: $mailerContent, to: $email, subject: 'Demand Added');
            $this->addFlash('success',"demand added successfully ");
            return $this->redirectToRoute('demand.list');
        }

        return $this->render('demand/add-demand.html.twig',[
            'f'=>$form->createView(),
            'isEdit'=>false,
            'demandType'=>$reqValue
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
            'isEdit'=>true,
            'demandType'=>''
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