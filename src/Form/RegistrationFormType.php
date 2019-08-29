<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('site',EntityType::class, [
                'class'=>Site::class,
                'choice_label'=>'nom',
                'label'=>'Organisme',
                'trim'=>true,
                'attr'=> array('class'=>'form-control')
            ])
            ->add('email', EmailType::class,[
                'label'=>'Email',
                'trim'=>true
            ])
            ->add('pseudo', TextType::class,[
                'label'=>'Pseudo',
                'trim'=>true,
                'required'=>false
            ])
            ->add('prenom', TextType::class,[
                'label'=>'Prénom',
                'trim'=>true
            ])
            ->add('nom', TextType::class,[
                'label'=>'Nom',
                'trim'=>true
            ])
            ->add('telephone', TextType::class,[
                'label'=>'Téléphone',
                'trim'=>true
            ])

            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller

                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe n\'est pas identique' ,
                'trim'=>true,
                'label' => 'Confirmation du Mot de passe',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit être au moins de {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [

                "label" => "Inscription",]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
