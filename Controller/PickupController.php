<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\PickupType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PickupController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire Enlèvement
     * 
     * @Route("/services/{id}/pickup", name="pickup")
     * @param Service $service
     * @return form
     */
    public function pickup(Service $service, Request $request, ObjectManager $manager)
    {
        $pageIcon = ($service->getServiceCategory()->getTitle() === "Course") ? 'far fa-clock' : 'fas fa-truck';
        
        $form = $this->createForm(PickupType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();// Récupération de l'utilisateur connecté
            $dateNow = new \DateTime();
    
            $service->setRealPickupDate($dateNow)
                    ->setPickupSigning("signature")
                    ->setUserPicker($user);
            
            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'enlèlevement pour {$service->getThirdShipper()->getName()} a bien été pris en compte et enregistrée !"
            );

        }

        return $this->render('pickup/index.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
            'pageIcon' => $pageIcon,
            'pageTitle' => NULL
        ]);
    }
}
