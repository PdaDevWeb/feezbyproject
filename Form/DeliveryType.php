<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\DeliveryState;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DeliveryType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'deliveryState',
                EntityType::class,
                [
                    'class' => DeliveryState::class,
                    'choice_label' => 'title',
                    'label' => 'Statut',
                    'placeholder' => 'Sélectionnez ...'
                ]
            )            
            ->add(
                'deliveredPackages',
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
                'deliveryComment',
                TextareaType::class,
                $this->getConfiguration(
                    "Commentaire(s)",
                    false
                )
            )
            ->add(
                'deliverySignerName',
                TextType::class,
                $this->getConfiguration(
                    "Signataire",
                    "Nom du signataire"
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
