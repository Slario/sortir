<?php


namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserEditType extends AbstractType
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
                    'mimeTypesMessage' => 'Merci de choisir une image valide !' ,
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
        $builder->add('telephone', TextType::class, [
            "error_bubbling" => true,
            "trim" => true,
            "label" => "Téléphone",
            "required" => false,
            'attr' => array('class' => 'form-control form-control-lg'),
        ]);
        $builder->add('plainPassword', PasswordType::class, [
            'label'  => "Mot de passe",
            'attr' => array('class' => 'form-control form-control-lg'),
            'required' => true,
        ]);
        $builder->add('site',EntityType::class, [
            'class'=>Site::class,
            'choice_label'=>'nom',
            'label'=>'Organisme',
            'trim'=>true,
            'attr'=> array('class'=>'form-control')
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}