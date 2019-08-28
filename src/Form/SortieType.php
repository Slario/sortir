<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom de la sortie'
            ])
            ->add('dateDebut',DateType::class,[
                'label'=>'Date et heure de sortie',
            ])
            ->add('dateCloture',DateType::class,[
                'label'=>'Date limite d\'inscription'
            ])
            ->add('nbInscriptionsMax',NumberType::class,[
                'label'=>'Nombre de places'
            ])
            ->add('duree',DateType::class,[
                'label'=>'Durée'
            ])
            ->add('descriptionInfos',TextareaType::class,[
                'label'=>'Descriptionet infos',
                'trim'=>true,
            ])

            ->add('organisateur',EntityType::class,[
                'class'=>User::class,
                'label'=>'Organisateur',
                'trim'=>true,
            ])
            ->add('site',EntityType::class,[
                'class'=>Site::class,
                'choice_label'=>'nom',
                'label'=>'Organisme',
                'trim'=>true,
            ])

            ->add('lieu',EntityType::class,[
                'class'=>Lieu::class,
                'choice_label'=>'nomLieu',
                'label'=>'Lieu',
                'trim'=>true,
            ])
            ->add('submit', SubmitType::class, [

                "label" => "Enregistrer",]);
    }





    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
