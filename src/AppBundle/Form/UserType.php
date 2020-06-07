<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('reference', TextType::class,array('label' => 'Reference','required'  => true,'attr' => array('class' =>'form-control')))
            ->add('nomLabo', TextType::class,array('label' => 'Nom laboratoire','required'  => true,'attr' => array('class' =>'form-control')))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe','required'  => true,'attr' => array('class' =>'form-control')),
                'second_options' => array('label' => 'Repeter mot de passe','required'  => true,'attr' => array('class' =>'form-control')),
            ))
            ->add('save', SubmitType::class, array('label' =>'Ajouter', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-bottom : 20px ; float: right;')))
            
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
