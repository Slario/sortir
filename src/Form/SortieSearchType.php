<?php

namespace App\Form;

use App\Entity\Site;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SortieSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', EntityType::class,
                ['class'=>Site::class,
                    'required'=>false,
                    'placeholder'=> 'Aucun site sélectionné',
                    'attr'=>['class' => 'form-control',
                        ]]
                )
            ->add('nom', TextType::class,
                ['attr'=>['placeholder'=>'Votre recherche...',
                    'class' => 'form-control'],
                    'required'=>false])
            ->add('dateMin', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required'=>false,


                ])
            ->add('dateMax', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required'=>false,

            ])
            ->add('checkbox', ChoiceType::class,
                ['expanded'=>true,
                'multiple'=>true,
                'choices'=>[
                    'Sorties pour lesquelles je suis l\'organisateur/trice'=>'userIsOrga',
                    'Sorties auxquelles je suis inscrit/e'=>'userSubscribed',
                    'Sorties auxquelles je ne suis pas inscrit/e'=>'userNotSubscribed',
                    'Sorties passées'=>'sortiesFinies'],
                    'label_attr'=>['display'=>'block'],
                    'attr'=>['class' => 'form-control',
                    ],
                    'choice_attr' => function($choice, $key, $value) {

                        return ['class' => 'form-group'];
                    },


            ])
            ->add('rechercher', SubmitType::class, [
                'attr'=> array('class'=>'bouton'),
                "label" => "Rechercher",])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
        ]);
    }
}
