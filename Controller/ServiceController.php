<?php

/**
 * Class ServiveController
 * Developer : Patrick Dambreville
 * Contain all the properties and methods(actions) related to Services
 */

namespace App\Controller;

use App\Entity\Service;
use App\Entity\OwnerHistoric;
use App\Repository\ServiceRepository;
use App\Repository\ServiceCategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{

    /**
     * Allow user to show all the services
     * 
     * @Route("/services/all", name="all_services")
     */
    public function showAllServices(ServiceRepository $repository)
    {
        $services = $repository->findAll();
        $count = count($services);
        $pageTitle = "TOUTES LES MISSIONS";
        $pageIcon = "fas fa-tasks";
        $buttonCaptionFooter = "";
        
        return $this->render('service/index.html.twig', [
            'services' => $services,
            'count' => $count,
            'pageTitle' => $pageTitle,
            'pageIcon' => $pageIcon,
            'buttonCaptionFooter' => $buttonCaptionFooter
        ]);
    }

    /**
     * Permet d'afficher la liste des courses
     * (livraisons le même jour) du User connecté
     * 
     * @Route("/services/user/sameDayDeliveries", name="user_same_day_deliveries")
     * 
     * @return Response
     */
    public function showUserSameDayDeliveries(ServiceRepository $serviceRepo, ServiceCategoryRepository $serviceCategoryRepo, ObjectManager $manager)
    {
        $userOwner = $this->getUser();
        $userId = $userOwner->getId();
        
        $serviceCategory = "Course";
        $serviceCategories = $serviceCategoryRepo->findOneByTitle($serviceCategory);
        $serviceCategoryId = $serviceCategories->getId();

        $query = $manager->createQuery('SELECT s FROM App\Entity\Service s WHERE (s.userOwner = :userOwner AND s.serviceCategory = :serviceCategoryId) AND s.realDeliveryDate IS NULL');
        $query->setParameters(array(
            'userOwner' => $userId,
            'serviceCategoryId' => $serviceCategoryId
        ));        
        $services = $query->getResult();
        dump($services);

        $pageTitle = "MES COURSES";
        $buttonCaptionFooter = "la Course";
        $count = count($services);
        $pageIcon = "far fa-clock";

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'count' => $count,
            'pageTitle' => $pageTitle,
            'pageIcon' => $pageIcon,
            'buttonCaptionFooter' => $buttonCaptionFooter
        ]);
    }

    /**
     * Permet d'afficher la liste des messageries
     * (livraisons le jour suivant) du User connecté
     * 
     * @Route("/services/user/nextDayDeliveries", name="user_next_day_deliveries")
     * 
     * @return Response
     */
    public function showUserNextDayDeliveries(ServiceRepository $serviceRepo, ServiceCategoryRepository $serviceCategoryRepo, ObjectManager $manager)
    {
        $userOwner = $this->getUser();
        $userId = $userOwner->getId();
        
        $serviceCategory = "Messagerie";
        $serviceCategories = $serviceCategoryRepo->findOneByTitle($serviceCategory);
        $serviceCategoryId = $serviceCategories->getId();

        $query = $manager->createQuery('SELECT s FROM App\Entity\Service s WHERE (s.userOwner = :userOwner AND s.serviceCategory = :serviceCategoryId) AND s.realDeliveryDate IS NULL');
        $query->setParameters(array(
            'userOwner' => $userId,
            'serviceCategoryId' => $serviceCategoryId
        ));        
        $services = $query->getResult();

        $pageTitle = "MES MESSAGERIES";
        $buttonCaptionFooter = "la Messagerie";
        $count = count($services);
        $pageIcon = "fas fa-truck";

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'count' => $count,
            'pageTitle' => $pageTitle,
            'pageIcon' => $pageIcon,
            'buttonCaptionFooter' => $buttonCaptionFooter
        ]);
    }

    /**
     * Permet d'afficher la liste des Services non encore
     * attribuées à un user
     * 
     * @Route("/services/notAttributed", name="services_notAttributed")
     */
    public function showNotAttributedServices(ServiceRepository $serviceRepo)
    {
        $userOwner = NULL;
        $services = $serviceRepo->findByUserOwner($userOwner);
        $count = count($services);
        $pageTitle = "MISSIONS EN ATTENTE";
        $buttonCaptionFooter = "la Mission";
        $pageIcon = "fas fa-question";

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'count' => $count,
            'pageTitle' => $pageTitle,
            'pageIcon' => $pageIcon,
            'buttonCaptionFooter' => $buttonCaptionFooter
        ]);
    }
    
    /**
     * Permet d'attribuer une mission à l'utilisateur connecté
     *
     * @Route("services/user/{id}/assign", name="user_assign_service")
     * 
     * @param Service $service
     * @param ObjectManager $manager
     * @return Response
     */
    public function assignAService(Service $service, ObjectManager $manager){

        $userOwner = $this->getUser();

        $service->setUserOwner($userOwner);        
        $manager->persist($service);
        
        $ownerHistoric = new OwnerHistoric();
        $commentAuto = "l'utilisateur " . $userOwner->getFullName() . " s'est attribué ce service.";

        $ownerHistoric->setUser($userOwner)
                      ->setService($service)
                      ->setCommentAuto($commentAuto);

        $manager->persist($ownerHistoric);

        $nameShipper = $service->getThirdShipper()->getName();

        $nameReceiver = (is_null($service->getThirdReceiver())) ?
                         'NC' :
                         $service->getThirdReceiver()->getName(); 
        
        $nameUser = $userOwner->getFullName();
        
        $manager->flush();

        $this->addFlash(
            'success',
            "La mission concernant l'expéditeur <strong>{$nameShipper}</strong> et le destinataire <strong>{$nameReceiver}</strong> a bien été attribuée à l'utilisateur <strong>{$nameUser}</strong> !"
        );

        return $this->redirectToRoute("services_notAttributed");
        
    }

    /**
     * Permet de désattribuer une mission à l'utilisateur connecté
     *
     * @Route("services/user/{id}/unassign", name="user_unassign_service")
     * 
     * @param Service $service
     * @param Manger $manger
     * @return Response
     */
    public function unAssignAService(Service $service, ObjectManager $manager) { 

        $userOwner = $this->getUser(); // Récupération de l'utilisateur actuellement connecté

        $service->setUserOwner(NULL); // Le service actuel n'est plus attribué
        $manager->persist($service);

        $nameShipper = $service->getThirdShipper()->getName();
        
        $nameReceiver = (is_null($service->getThirdReceiver())) ?
                         'NC' :
                         $service->getThirdReceiver()->getName();         
        
                         $nameUser = $userOwner->getFullName();

        $manager->flush();

        $this->addFlash(
            'success',
            "La mission concernant l'expéditeur <strong>{$nameShipper}</strong> et le destinataire <strong>{$nameReceiver}</strong> a bien été retirée à l'utilisateur <strong>{$nameUser}</strong> !"
        );

        return $this->redirectToRoute("user_same_day_deliveries");
    }


    
}
