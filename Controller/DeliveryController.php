<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\DeliveryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeliveryController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire de Livraison
     * 
     * @Route("/services/{id}/delivery", name="delivery")
     * @param Service $service
     * @return form
     */
    public function delivery(Service $service, Request $request, ObjectManager $manager)
    {
        $pageIcon = ($service->getServiceCategory()->getTitle() === "Course") ? 'far fa-clock' : 'fas fa-truck';
        
        $form = $this->createForm(DeliveryType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();// Récupération de l'utilisateur connecté
            $dateNow = new \DateTime();
    
            $service->setRealDeliveryDate($dateNow)
                    ->setDeliverySigning("signature")
                    ->setUserDeliver($user);
            
            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                "La livraison pour {$service->getThirdReceiver()->getName()} a bien été pris en compte et enregistrée !"
            );

        }

        return $this->render('delivery/index.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
            'pageIcon' => $pageIcon,
            'pageTitle' => NULL
        ]);
    }
}
