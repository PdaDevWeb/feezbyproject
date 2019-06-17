<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\PickupState;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PickupType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'pickupState',
                EntityType::class,
                [
                    'class' => PickupState::class,
                    'choice_label' => 'title',
                    'label' => 'Statut',
                    'placeholder' => 'Sélectionnez ...'
                ]
            )            
            ->add(
                'pickedUpPackages',
                IntegerType::class,
                $this->getConfiguration(
                    "Nombre colis",
                    false,
                    [
                        'attr' => [
                            'value' => 1,
                            'min' => 1,
                            'step' => 1
                        ]
                    ]
                )
            )
            ->add(
                'pickupComment',
                TextareaType::class,
                $this->getConfiguration(
                    "Commentaire(s)",
                    false
                )
            )
            ->add(
                'pickupSignerName',
                TextType::class,
                $this->getConfiguration(
                    "Signataire",
                    "Nom du signataire"
                )
            )
            //->add('userPicker')
            //->add('pickupState')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
