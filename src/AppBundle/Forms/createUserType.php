<?php

/**
 * Created by PhpStorm.
 * User: axel
 * Date: 30/12/2016
 * Time: 15:00
 */
namespace AppBundle\Forms;


use AppBundle\Entity\Doctor;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityManager;



class createUserType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('username',TextType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, array(
                'attr' => ['class' => 'btn waves-effect waves-light center-align ']

            ));

    }


    public function	configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array('user_class' => Doctor::class));
    }

}