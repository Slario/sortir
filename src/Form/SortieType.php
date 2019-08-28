<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateDebut', DateType::class)
            ->add('duree', NumberType::class)
            ->add('dateCloture', DateType::class)
            ->add('nbInscriptionsMax', NumberType::class)
            ->add('descriptionInfos', TextareaType::class)
            //->add('urlPhoto')
            ->add('organisateur', EntityType::class,
                ['class' => User::class,
                    ])
            ->add('site', EntityType::class,
                ['class' => Site::class,
                    'choice_label' => 'nom'])
            ->add('lieu', EntityType::class,
                ['class' => Lieu::class,
                'choice_label' => 'nomLieu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
