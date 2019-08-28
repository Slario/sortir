<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder-> add ( 'img' , FileType :: class , [
            'label' => 'Photo (jpg, png)' ,
            'mapped' => false ,
            'required' => false ,
            'constraints' => [
                new File ([
                    'maxSize' => '1024k' ,
                    'mimeTypesMessage' => 'Please upload a valid img document' ,
                ])
            ],
        ]);
        $builder->add('pseudo', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Pseudo",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('prenom', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Prénom",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('nom', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Nom",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('telephone', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Téléphone",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('email', EmailType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Email",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent être identiques',
            'options' => ['attr' => ['class' => 'form-control form-control-lg']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmation mot de passe'],
        ]);
        $builder->add('villeRattachement', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Ville de rattachement",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}