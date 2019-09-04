<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie',
                'attr' => array('class' => 'form-control')
            ])
            ->add('dateDebut', DateTimeType::class, array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('dateCloture', DateTimeType::class, array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => array('class' => 'form-control')

            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée en minutes',
                'attr' => array('class' => 'form-control', 'min' => '0', 'step' => '15'),

            ])
            ->add('descriptionInfos', TextareaType::class, [
                'label' => 'Description et infos',
                'trim' => true,
                'attr' => array('class' => 'form-control')
            ])
            /*->add('organisateur',EntityType::class,[
                'class'=>User::class,
                'label'=>'Organisateur',
                'disabled'=>true,
                'trim'=>true,
                'attr'=> array('class'=>'form-control')
            ])*/
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'label' => 'Ville',
                'trim' => true,
                'attr' => array('class' => 'form-control'),
                'mapped' => false,
            ])
            /*->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nomLieu',
                'label' => 'Lieu',
                'trim' => true,
                'attr' => array('class' => 'form-control')
            ])*/
            ->add('enregistrer', SubmitType::class, [
                'attr' => array('class' => 'bouton'),
                "label" => "Enregistrer"
            ])
            ->add('publier', SubmitType::class, [
                'attr' => array('class' => 'bouton'),
                "label" => "Publier"
            ])
            ->add('annuler', SubmitType::class, [
                'attr' => array('class' => 'bouton'),
                'label' => "Annuler"
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
